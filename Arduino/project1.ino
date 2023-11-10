#include <WiFi.h>
#include <HTTPClient.h>
#include <ArduinoJson.h>
#include "DHTesp.h"

#define DHT_PIN 27
#define RELAY_PIN 26
#define LED_PIN 2

struct SensorData {
  double temperature;
  double dew_temperature;
  double humidity;
};

const char* ssid = "Bartek-wifi";
const char* password = "bartek321";
const char* endpoint = "https://mikropr.byst.re/api/";
const char* token = "a0b00d4c-689e-4886-9b4c-d65248d669e2";


DHTesp dhtSensor;
int frequencySeconds = 600;
int fanActiveUnderValue = 10;

String toJsonString(DynamicJsonDocument& jsonDoc) {
  String jsonString;
  serializeJson(jsonDoc, jsonString);
  return jsonString;
}

double calculateDewPoint(double humidity, double temp){
  return std::pow(humidity / 100.0, 1.0 / 8.0) * (112 + (0.9 * temp)) + (0.1 * temp) - 112;
}

DynamicJsonDocument sendRequest(const char* path, const char* method = "GET", const char* postData = ""){
  if(WiFi.status() != WL_CONNECTED){
    Serial.print("Połączenie z wifi przerwane. Ponawiam próbę \n");
    connectWifi();
  }
  Serial.print("Wysyłam żądanie "+String(method)+" na endpoint: "+String(path)+" z danymi: "+String(postData)+"\n");
  HTTPClient http;
  String fullURL = String(endpoint) + String(path);
  http.begin(fullURL.c_str());
  DynamicJsonDocument jsonResponse(1024);
  http.addHeader("Authorization", String("Bearer ") + token);

  int httpResponseCode = 0;
  if (strcmp(method, "POST") == 0) {
    http.addHeader("Content-Type", "application/x-www-form-urlencoded");
    httpResponseCode = http.POST(postData);
  }
  else {
    httpResponseCode = http.GET();
  }


  String response = http.getString();
  DeserializationError error = deserializeJson(jsonResponse, response);
  Serial.print("Odpowiedz serwera: ");
  Serial.print(toJsonString(jsonResponse)+"\n");
  Serial.print("Kod odpowiedzi: ");
  Serial.print(httpResponseCode);
  Serial.print("\n");
  if (httpResponseCode == 200 && !error) {
    return jsonResponse;
  }
  return DynamicJsonDocument(0);
}

bool loadSettings() {
  DynamicJsonDocument response = sendRequest("settings");
  if (response.containsKey("data")) {
    JsonObject data = response["data"];
    frequencySeconds = data["frequency_seconds"].as<int>();
    fanActiveUnderValue = data["fan_active_under_value"].as<int>();
    Serial.print("Pobrane ustawienia częstotliwość: ");
    Serial.print(frequencySeconds);
    Serial.print("s Próg aktywacji: ");
    Serial.print(fanActiveUnderValue);
    Serial.print(" %\n");
    return true;
  }
  return false;
}

SensorData getSensorData() {
  SensorData result;
  TempAndHumidity  data = dhtSensor.getTempAndHumidity();
  double dewPoint = calculateDewPoint(data.humidity, data.temperature);
  result.temperature = data.temperature;
  result.humidity = data.humidity;
  result.dew_temperature = dewPoint;
  return result;
}

bool fanActivate(SensorData sensorData){
  double minTemperature = (1-static_cast<double>(fanActiveUnderValue) / 100) * sensorData.temperature;
  if (sensorData.dew_temperature >= minTemperature) return true;
  return false;
}

void sendSensorData(SensorData sensorData, bool fanActive) {
  int fanActiveInt = fanActive ? 1 : 0;
  String postData = "temperature="+String(sensorData.temperature, 2)+
    "&humidity="+String(sensorData.humidity, 2)+
    "&dew_temperature="+String(sensorData.dew_temperature, 2)+
    "&fan_active="+String(fanActiveInt);

  sendRequest(
    "sensor-data", 
    "POST", 
    postData.c_str()
  );
}

void startSensor(){
  int i = 0;
  while(!loadSettings() && i < 3){
    delay(500);
    i++;
  }
  SensorData data = getSensorData();
  if(isnan(data.humidity) || isnan(data.temperature)){
    Serial.print("Error: niepoprawny odczyt z czujnika\n");
    digitalWrite(LED_PIN, HIGH); 
  }
  else{
    digitalWrite(LED_PIN, LOW); 
    bool activateFan = fanActivate(data);
    if(activateFan){
      Serial.print("Włączyć wiatrak\n");
      digitalWrite(RELAY_PIN, LOW);
    }
    else{
      Serial.print("Wyłączyć wiatrak\n");
      digitalWrite(RELAY_PIN, HIGH);
    }

    sendSensorData(data, activateFan);
  }
}

void connectWifi(){
  WiFi.begin(ssid, password, 6);
  uint32_t notConnectedCounter = 0;
  Serial.print("Łączenie z WiFi");
  while (WiFi.status() != WL_CONNECTED) {
      digitalWrite(LED_PIN, HIGH); 
      delay(100);
      digitalWrite(LED_PIN, LOW); 
      delay(100);
      Serial.print(".");
      notConnectedCounter++;
      if(notConnectedCounter > 100) { 
          Serial.println("Restart urządzenia z powodu problemu z połączeniem z wifi...");
          ESP.restart();
      }
  }
  digitalWrite(LED_PIN, LOW); 
  Serial.print("OK! IP=");
  Serial.println(WiFi.localIP());
}

void setup() {
  Serial.begin(115200);
  pinMode(LED_PIN, OUTPUT); 
  dhtSensor.setup(DHT_PIN, DHTesp::DHT22);
  connectWifi();
  pinMode(RELAY_PIN, OUTPUT);
}

void loop() {
  startSensor();
  delay(frequencySeconds*1000);
}