<?php

namespace App\Http\Controllers;

use App\Models\Document;
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

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        $documents = Document::where('user_id', $user->id)
            ->when($request->filled('search'), function ($query) use ($request) {
                $query->where('bulan_periode', 'like', '%' . $request->search . '%');
            })
            ->select('bulan_periode', 'tahun_periode')
            ->groupBy('bulan_periode', 'tahun_periode')
            ->orderBy('tahun_periode', 'desc')
            ->get();

        return view('home', compact('documents'));
    }
}