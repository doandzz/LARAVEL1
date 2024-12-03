<?php

namespace App\Http\Controllers;

use App\Models\Settings_time;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SettingsController extends Controller
{
    public function index(Request $request)
    {

        $settings = Settings_time::limit(10)->get();

        foreach ($settings as $data) {
            $data->start_time = Carbon::parse($data->start_time)->format('H:i');
            $data->end_time = Carbon::parse($data->end_time)->format('H:i');
            $data->end_try_time = Carbon::parse($data->end_try_time)->format('H:i');
        }

        return view('settings.time', compact('settings'));
    }

    public function update(Request $request)
    {
        // dd("fdsfds");
        // dd($request->all());
        // Update each Settings_time's data
        foreach ($request->settings as $settingId => $settingData) {
            $setting = Settings_time::find($settingId);
            if ($setting) {
                $setting->update([
                    'start_time' => $settingData['start_time'],
                    'end_time' => $settingData['end_time'],
                    'entry_time' => $settingData['end_try_time'],
                ]);
            }
        }
        // Flash message
        session()->flash('success', 'Thông tin đã được lưu');

        return redirect()->route('management-settings.list');
    }
}
