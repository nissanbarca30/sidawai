<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    /**
     * Setelah password berhasil di-reset, arahkan pengguna ke halaman login
     *
     * @var string
     */
    protected $redirectTo = '/login';

    /**
     * Opsional: Override pesan respons sukses agar menggunakan bahasa Indonesia
     */
    protected function sendResetResponse($request, $response)
    {
        return redirect($this->redirectPath())
            ->with('status', 'Password Anda berhasil diperbarui! Silakan login dengan password baru.');
    }
}