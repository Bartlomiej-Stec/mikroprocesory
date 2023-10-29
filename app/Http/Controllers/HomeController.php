<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\GetDataRequest;
use App\Http\Requests\SaveSettingsRequest;
use App\Models\HistoricalData;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function saveSettings(SaveSettingsRequest $request)
    {
        Settings::where('user_id', auth()->user()->id)
            ->update(
                [
                    'fan_active_under_value' => $request->input('fan_active_under_value'),
                    'frequency_seconds' => $request->input('frequency_seconds')
                ]
            );
        return redirect()->back();
    }

    public function getData(GetDataRequest $request)
    {
        $daysAgo = now()->subDays($request->period);
        $data = HistoricalData::where('user_id', auth()->user()->id)->where('created_at', '>=', $daysAgo)->orderBy('created_at', 'DESC')->limit(100)->get();
        return response()->json(['status' => 'ok', 'data' => $data]);
    }
}
