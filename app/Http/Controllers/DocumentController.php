<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class DocumentController extends Controller
{
    private array $namaBulan = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
    ];

    public function create()
    {
        return view('document.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori'        => 'required|in:data_dukung,rekap_presensi',
            'tanggal_mulai'   => 'nullable|required_if:kategori,data_dukung|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan'      => 'required|string',
            'lampiran'        => 'required|array',
            'lampiran.*'      => 'file|mimes:pdf,jpg,jpeg,png|max:5048',
        ]);

        $userId = Auth::id();

        // 1. Penentuan Folder Bulan & Tanggal
        if ($request->kategori === 'rekap_presensi') {
            $today = Carbon::now();

            $refDate = $today->day <= 25 ? $today->copy()->subMonth() : $today->copy();

            $bulanPeriode = $this->namaBulan[$refDate->month];
            $tahunPeriode = $refDate->year;

            $dbTanggal = $today->format('Y-m-d');
            $finalKeterangan = '[REKAP PRESENSI] ' . $request->keterangan;
        } else {
            // Data Dukung: Simpan tanggal_mulai ke kolom tanggal
            $startDate = Carbon::parse($request->tanggal_mulai);
            $bulanPeriode = $this->namaBulan[$startDate->month];
            $tahunPeriode = $startDate->year;

            $dbTanggal = $startDate->format('Y-m-d');

            // Jika ada rentang tanggal, tambahkan catatan rentangnya di Keterangan
            if ($request->tanggal_selesai && $request->tanggal_selesai !== $request->tanggal_mulai) {
                $endDate = Carbon::parse($request->tanggal_selesai);
                $rentangTeks = "(Izin Tgl " . $startDate->format('d/m/Y') . " s/d " . $endDate->format('d/m/Y') . ") ";
                $finalKeterangan = $rentangTeks . $request->keterangan;
            } else {
                $finalKeterangan = $request->keterangan;
            }
        }

        // 2. Simpan File Privat ('local') & Buat Record Database
        foreach ($request->file('lampiran') as $file) {
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs("documents/{$tahunPeriode}/{$bulanPeriode}", time() . '_' . $fileName, 'local');

            Document::create([
                'user_id'       => $userId,
                'kategori'      => $request->kategori,
                'tanggal'       => $dbTanggal,
                'keterangan'    => $finalKeterangan,
                'file_path'     => $path,
                'file_name'     => $fileName,
                'bulan_periode' => $bulanPeriode,
                'tahun_periode' => $tahunPeriode,
            ]);
        }

        return redirect()->route('home')->with('success', 'Dokumen berhasil disimpan!');
    }

    public function show($id)
    {
        $document = Document::with('user')->findOrFail($id);

        return view('document.show', compact('document'));
    }

    public function previewFile($id)
    {
        $document = Document::findOrFail($id);

        if (Auth::id() !== $document->user_id && !Auth::user()->isAdmin()) {
            abort(403, 'Akses ditolak. Anda tidak memiliki izin melihat berkas ini.');
        }

        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        $fullPath = Storage::disk('local')->path($document->file_path);

        return response()->file($fullPath);
    }

    public function byMonth($bulan)
    {
        $documents = Document::where('user_id', Auth::id())
            ->where('bulan_periode', $bulan)
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('document.index_month', compact('documents', 'bulan'));
    }

    public function edit($id)
    {
        $document = Document::where('user_id', Auth::id())->findOrFail($id);

        return view('document.edit', compact('document'));
    }

    public function update(Request $request, $id)
    {
        $document = Document::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'tanggal_mulai'   => 'nullable|required_if:kategori,data_dukung|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan'      => 'required|string',
            'lampiran'        => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5048',
        ]);

        $rawKeterangan = preg_replace('/^\(Izin Tgl [0-9\/]+ s\/d [0-9\/]+\)\s*/', '', $request->keterangan);
        $rawKeterangan = str_replace('[REKAP PRESENSI] ', '', $rawKeterangan);

        if ($document->kategori === 'rekap_presensi') {
            $dbTanggal = $document->tanggal;
            $finalKeterangan = '[REKAP PRESENSI] ' . $rawKeterangan;
            $bulanPeriode = $document->bulan_periode;
            $tahunPeriode = $document->tahun_periode;
        } else {
            $startDate = Carbon::parse($request->tanggal_mulai);
            $bulanPeriode = $this->namaBulan[$startDate->month];
            $tahunPeriode = $startDate->year;
            $dbTanggal = $startDate->format('Y-m-d');

            if ($request->tanggal_selesai && $request->tanggal_selesai !== $request->tanggal_mulai) {
                $endDate = Carbon::parse($request->tanggal_selesai);
                $rentangTeks = "(Izin Tgl " . $startDate->format('d/m/Y') . " s/d " . $endDate->format('d/m/Y') . ") ";
                $finalKeterangan = $rentangTeks . $rawKeterangan;
            } else {
                $finalKeterangan = $rawKeterangan;
            }
        }

        $updateData = [
            'tanggal'       => $dbTanggal,
            'keterangan'    => $finalKeterangan,
            'bulan_periode' => $bulanPeriode,
            'tahun_periode' => $tahunPeriode,
        ];

        if ($request->hasFile('lampiran')) {
            if (Storage::disk('local')->exists($document->file_path)) {
                Storage::disk('local')->delete($document->file_path);
            }

            $file = $request->file('lampiran');
            $fileName = $file->getClientOriginalName();
            $path = $file->storeAs("documents/{$tahunPeriode}/{$bulanPeriode}", time() . '_' . $fileName, 'local');

            $updateData['file_path'] = $path;
            $updateData['file_name'] = $fileName;
        }

        $document->update($updateData);

        return redirect()->route('document.month', $bulanPeriode)->with('success', 'Data berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $document = Document::where('user_id', Auth::id())->findOrFail($id);
        $bulanPeriode = $document->bulan_periode;

        if (Storage::disk('local')->exists($document->file_path)) {
            Storage::disk('local')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('document.month', $bulanPeriode)->with('success', 'Data berhasil dihapus!');
    }

    public function downloadZip($bulan)
    {
        $userId = Auth::id();

        $documents = Document::where('user_id', $userId)
            ->where('bulan_periode', $bulan)
            ->orderBy('tanggal', 'asc')
            ->get();

        if ($documents->isEmpty()) {
            return back()->with('error', 'Tidak ada file untuk didownload');
        }

        $tahun = $documents->first()->tahun_periode;

        $zip = new ZipArchive();
        $zipFileName = "Dokumen_Presensi_{$bulan}_{$tahun}.zip";
        $zipPath = storage_path("app/{$zipFileName}");

        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            // 1. Generate PDF Rekap Keterangan
            $pdf = Pdf::loadView('pdf.rekap_bulan', compact('documents', 'bulan', 'tahun'));
            $zip->addFromString("Rekap_Keterangan_{$bulan}_{$tahun}.pdf", $pdf->output());

            foreach ($documents as $doc) {
                if (Storage::disk('local')->exists($doc->file_path)) {
                    $filePath = Storage::disk('local')->path($doc->file_path);
                    $kategori = $doc->kategori ?? 'data_dukung';

                    if ($kategori === 'rekap_presensi') {
                        $zipPathInZip = "Rekap_Presensi/" . $doc->file_name;
                    } else {
                        $folderTanggal = Carbon::parse($doc->tanggal)->format('d-m-Y');
                        $zipPathInZip = "Data_Dukung/{$folderTanggal}/" . $doc->file_name;
                    }

                    $zip->addFile($filePath, $zipPathInZip);
                }
            }
            $zip->close();
        }
        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}