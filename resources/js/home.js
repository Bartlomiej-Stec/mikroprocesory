
var chart = null;
function sendRequest(url, method = 'GET', data = {}) {
    return new Promise((resolve, reject) => {
        const csrfToken = document.head.querySelector('meta[name="csrf-token"]').content;

        const options = {
            method,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken
            }
        };

        if (method === 'POST') {
            const formData = new URLSearchParams();
            for (const key in data) {
                formData.append(key, data[key]);
            }
            options.body = formData;
        }

        fetch(url, options)
            .then(response => {
                return response.json();
            })
            .then(data => resolve(data))
            .catch(error => reject(error));
    });
}

function createChart(labels, tempData, humidityData, dewTemp) {
    if (chart) {
        chart.data.labels = labels;
        chart.data.datasets[0].data = tempData;
        chart.data.datasets[1].data = dewTemp;
        chart.data.datasets[2].data = humidityData;
        chart.update();
    }
    else {
        var ctx = document.getElementById("myChart");
        chart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: "Temperatura",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(255, 0, 0, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: tempData,
                },
                {
                    label: "Temperatura punktu rosy",
                    lineTension: 0.3,
                    backgroundColor: "rgba(78, 115, 223, 0.05)",
                    borderColor: "rgba(0, 255, 0, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointBorderColor: "rgba(78, 115, 223, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                    pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: dewTemp,
                },
                {
                    label: "Wilgotność",
                    lineTension: 0.3,
                    backgroundColor: "rgba(223, 115, 78, 0.05)",
                    borderColor: "rgba(0, 0, 255, 1)",
                    pointRadius: 3,
                    pointBackgroundColor: "rgba(223, 115, 78, 1)",
                    pointBorderColor: "rgba(223, 115, 78, 1)",
                    pointHoverRadius: 3,
                    pointHoverBackgroundColor: "rgba(223, 115, 78, 1)",
                    pointHoverBorderColor: "rgba(223, 115, 78, 1)",
                    pointHitRadius: 10,
                    pointBorderWidth: 2,
                    data: humidityData,
                    yAxisID: 'humidity-axis',
                    label: 'Wilgotność',
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            return datasetLabel + ": " + tooltipItem.yLabel + "%";
                        }
                    }
                }],
            },
            options: {
                maintainAspectRatio: false,
                layout: {
                    padding: {
                        left: 10,
                        right: 25,
                        top: 25,
                        bottom: 0
                    }
                },
                scales: {
                    xAxes: [{
                        time: {
                            unit: 'date'
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        },
                        ticks: {
                            maxTicksLimit: 7
                        }
                    }],
                    yAxes: [{
                        id: 'temperature-axis',
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function (value, index, values) {
                                return value + ' °C';
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }, {
                        id: 'humidity-axis',
                        position: 'right',
                        ticks: {
                            maxTicksLimit: 5,
                            padding: 10,
                            callback: function (value, index, values) {
                                return value + '%';
                            }
                        },
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        }
                    }],
                },
                legend: {
                    display: false
                },
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    titleMarginBottom: 10,
                    titleFontColor: '#6e707e',
                    titleFontSize: 14,
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false,
                    intersect: false,
                    mode: 'index',
                    caretPadding: 10,
                    callbacks: {
                        label: function (tooltipItem, chart) {
                            var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                            if (datasetLabel === 'Temperatura' || datasetLabel == "Temperatura punktu rosy") {
                                return datasetLabel + ": " + tooltipItem.yLabel + " °C";
                            } else if (datasetLabel === 'Wilgotność') {
                                return datasetLabel + ": " + tooltipItem.yLabel + "%";
                            } else {
                                return datasetLabel + ": " + tooltipItem.yLabel;
                            }
                        }
                    }
                }
            }
        });
    }
}

function convertDate(dateString) {
    var date = new Date(dateString);

    var options = {
        year: "numeric",
        month: "long",
        day: "numeric",
        hour: "2-digit",
        minute: "2-digit",
        second: "2-digit",
        timeZoneName: "short"
    };

    return date.toLocaleDateString("pl-PL", options);
}

function refreshData() {
    var period = document.querySelector('#period').value;
    sendRequest('/historical-data?period=' + period, 'GET').then(response => {
        var content = document.querySelector('#results');
        content.innerHTML = '';
        var data = { humidity: [], temperature: [], dew_temp: [], dates: [] };
        if (response.status == "ok") {
            response.data.forEach(element => {
                var convertedDate = convertDate(element.created_at);
                var fanActive = element.fan_active == 1 ? "TAK" : "NIE";
                content.insertAdjacentHTML('beforeend', '<tr><td>' + convertedDate + '</td><td>' + element.humidity + ' %</td><td>' + element.temperature + ' °C</td><td>' + element.dew_temperature + ' °C</td><td>' + fanActive + '</td></tr>')
                data['humidity'].push(element.humidity);
                data['temperature'].push(element.temperature);
                data['dates'].push(convertedDate);
                data['dew_temp'].push(element.dew_temperature);
            });
        }
        data.temperature.reverse();
        data.humidity.reverse();
        data.dew_temp.reverse();
        data.dates.reverse();
        createChart(data.dates, data.temperature, data.humidity, data.dew_temp);
    });
}

document.querySelector('#period').addEventListener('change', refreshData);
setInterval(refreshData, 15000);

document.addEventListener('DOMContentLoaded', function () {
    var copyButton = document.getElementById('copyButton');
    var textToCopy = document.querySelector('.card-body p');

    copyButton.addEventListener('click', function () {
        var textArea = document.createElement('textarea');
        textArea.value = textToCopy.textContent;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
    });

    refreshData();
});