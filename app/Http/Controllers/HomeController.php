<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HomeController extends Controller
{
    private const AI_PROVIDERS = [
        'openai' => [
            'gpt-4o' => 'GPT-4o',
            'gpt-4o-mini' => 'GPT-4o mini',
        ],
        'anthropic' => [
            'claude-3-5-sonnet-latest' => 'Claude 3.5 Sonnet',
            'claude-3-5-haiku-latest' => 'Claude 3.5 Haiku',
        ],
        'google' => [
            'gemini-2.0-flash' => 'Gemini 2.0 Flash',
            'gemini-2.0-pro' => 'Gemini 2.0 Pro',
        ],
    ];

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

        $selectedProvider = $user->ai_provider ?: 'openai';
        $selectedModel = $user->ai_model ?: 'gpt-4o-mini';
        $aiProviders = self::AI_PROVIDERS;

        return view('home', compact(
            'documents',
            'selectedYear',
            'availableYears',
            'selectedProvider',
            'selectedModel',
            'aiProviders'
        ));
    }

    public function updateAiPreferences(Request $request)
    {
        $validated = $request->validate([
            'ai_provider' => ['required', Rule::in(array_keys(self::AI_PROVIDERS))],
            'ai_model' => [
                'required',
                Rule::in(self::AI_PROVIDERS[$request->input('ai_provider')] ?? []),
            ],
        ]);

        $request->user()->update($validated);

        return redirect()->route('home')->with('status', 'Preferensi AI berhasil disimpan.');
    }
}