<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Contracts\Support\Renderable|\Illuminate\Http\RedirectResponse
     */

    

    public function index(Request $request)
    {
        $user = Auth::user();

        // Redirect jika role pengguna adalah Admin/Superadmin
        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $userId = $user->id;
        $currentYear = (int) Carbon::now()->year;

        // 1. Ambil pilihan tahun dari request, jika kosong gunakan tahun berjalan
        $selectedYear = $request->filled('tahun') ? (int) $request->tahun : $currentYear;

        // 2. Ambil daftar tahun unik dari database milik user untuk opsi dropdown
        $availableYears = Document::where('user_id', $userId)
            ->distinct()
            ->pluck('tahun_periode')
            ->filter()
            ->map(fn($year) => (int) $year)
            ->toArray();

        // Masukkan tahun berjalan jika belum ada di list agar tetap dapat dipilih
        if (!in_array($currentYear, $availableYears, true)) {
            $availableYears[] = $currentYear;
        }

        // Urutkan opsi tahun dari yang terbaru ke lama
        rsort($availableYears);

        // 3. Query daftar folder bulan berdasarkan tahun yang dipilih
        $documents = Document::where('user_id', $userId)
            ->where('tahun_periode', $selectedYear)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('bulan_periode', 'like', '%' . $request->search . '%');
            })
            ->select('bulan_periode', 'tahun_periode')
            ->groupBy('bulan_periode', 'tahun_periode')
            ->get();

        return view('home', compact('documents', 'selectedYear', 'availableYears'));
    }
}