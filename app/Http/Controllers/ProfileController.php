<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validasi data
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'nip'      => ['required', 'string', 'max:50', Rule::unique('users')->ignore($user->id)],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:8'], // Password opsional
        ], [
            'nip.unique'   => 'NIP ini sudah digunakan oleh akun lain.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
            'password.min' => 'Password baru minimal harus 8 karakter.',
        ]);

        $updateData = [
            'name'  => $request->name,
            'nip'   => $request->nip,
            'email' => $request->email,
        ];

        // Jika input password diisi, update passwordnya
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $user->update($updateData);

        return back()->with('success', 'Data profil berhasil diperbarui!');
    }
}