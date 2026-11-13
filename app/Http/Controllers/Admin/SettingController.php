<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function toggle($key)
    {
        // Ambil nilai setting saat ini (default '1')
        $currentValue = Setting::get($key, '1');
        
        // Ubah nilai: jika '1' jadi '0', jika '0' jadi '1'
        $newValue = $currentValue == '1' ? '0' : '1';
        
        // Simpan ke database
        Setting::set($key, $newValue);

        return redirect()->back()->with('status', 'Pengaturan berhasil diperbarui!');
    }
}
