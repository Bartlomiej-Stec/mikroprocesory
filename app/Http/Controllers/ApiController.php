<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddHistoricalDataRequest;
use App\Models\HistoricalData;

class ApiController extends Controller
{
    public function getSettings(Request $request)
    {
        return response()->json(["status" => "ok", "data" => $request->user->settings]);
    }

    public function addSensorData(AddHistoricalDataRequest $request)
    {
        HistoricalData::create([
            'user_id' => $request->user->id,
            'humidity' => $request->humidity,
            'temperature' => $request->temperature,
            'dew_temperature' => $request->dew_temperature,
            'fan_active' => $request->fan_active,
        ]);
        return response()->json(['status' => 'ok']);
    }
}
