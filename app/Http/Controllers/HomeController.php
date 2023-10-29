<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SaveSettingsRequest;
use App\Models\Settings;

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
}
