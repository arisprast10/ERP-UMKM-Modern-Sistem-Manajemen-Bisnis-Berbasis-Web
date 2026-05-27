<?php
namespace App\Http\Controllers;

use App\Models\StoreSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class StoreSettingController extends Controller
{
    public function index()
    {
        $setting = StoreSetting::first() ?? new StoreSetting();
        return view('settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'store_name' => 'required|string|max:255',
            'store_address' => 'nullable|string',
            'store_phone' => 'nullable|string|max:50',
            'store_logo' => 'nullable|image|max:2048'
        ]);

        $setting = StoreSetting::first();
        if (!$setting) {
            $setting = new StoreSetting();
        }

        $setting->store_name = $request->store_name;
        $setting->store_address = $request->store_address;
        $setting->store_phone = $request->store_phone;

        if ($request->hasFile('store_logo')) {
            if ($setting->store_logo) {
                Storage::disk('public')->delete($setting->store_logo);
            }
            $setting->store_logo = $request->file('store_logo')->store('settings', 'public');
        }

        $setting->save();
        
        Cache::forget('store_setting');

        return redirect()->back()->with('success', 'Pengaturan toko berhasil diperbarui.');
    }
}