<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    private const ROLES = ['superadmin', 'admin', 'pegawai'];

    private const BULAN = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    // =========================================================================
    // DASHBOARD
    // =========================================================================

    public function index()
    {
        $totalPegawai = User::count(); // termasuk admin
        $totalDokumen = Document::count();
        $users = User::withCount('documents')->latest()->get();

        // 1 = pendaftaran terbuka, 0 = terkunci
        $allowRegister = Setting::get('allow_register', '1') == '1';

        return view('admin.dashboard', compact('totalPegawai', 'totalDokumen', 'users', 'allowRegister'));
    }

    // =========================================================================
    // DATA PEGAWAI
    // =========================================================================

    public function usersIndex(Request $request)
    {
        $query = User::withCount('documents');

        $this->applySearch($query, $request);
        $this->applyRoleFilter($query, $request);
        $this->applySort($query, $request->sort);

        $users = $query->get();

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'nip'      => 'required|string|unique:users,nip',
            'password' => 'required|min:6',
            'role'     => 'nullable|in:pegawai,admin',
        ]);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'nip'      => $request->nip,
            'password' => Hash::make($request->password),
            'role'     => $request->role ?? 'pegawai',
        ]);

        return $this->redirectToUsers('success', 'Data pegawai berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'nip'   => 'required|string|unique:users,nip,' . $id,
            'role'  => 'nullable|in:pegawai,admin',
        ]);

        $data = $request->only('name', 'email', 'nip');

        // Role Superadmin tidak boleh diubah
        if ($request->filled('role') && $user->role !== 'superadmin') {
            $data['role'] = $request->role;
        }

        if ($request->filled('password')) {
            $request->validate(['password' => 'min:6']);
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return $this->redirectToUsers('success', 'Data pegawai berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $currentUser = Auth::user();

        if ($user->role === 'superadmin') {
            return $this->redirectToUsers('error', 'Akun Superadmin utama tidak dapat dihapus.');
        }

        if ($currentUser->id === $user->id) {
            return $this->redirectToUsers('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // Hanya Superadmin yang boleh menghapus akun ber-role Admin
        if ($user->role === 'admin' && !$currentUser->isSuperadmin()) {
            return $this->redirectToUsers('error', 'Hanya Superadmin yang berwenang menghapus akun Admin.');
        }

        $user->delete();

        return $this->redirectToUsers('success', 'Data pegawai/admin berhasil dihapus!');
    }

    // =========================================================================
    // KHUSUS SUPERADMIN: KELOLA HAK AKSES ADMIN
    // =========================================================================

    public function manageAdmins(Request $request)
    {
        $query = User::query();

        $this->applySearch($query, $request);
        $this->applyRoleFilter($query, $request);
        $this->applySort($query, $request->sort);

        $admins = $query->get();

        return view('admin.superadmin.admins', compact('admins'));
    }

    public function promoteToAdmin($id)
    {
        $user = User::findOrFail($id);
        $user->update(['role' => 'admin']);

        return back()->with('success', "{$user->name} berhasil dijadikan Admin.");
    }

    public function demoteToPegawai($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Tidak dapat mengubah role Superadmin utama.');
        }

        $user->update(['role' => 'pegawai']);

        return back()->with('success', "Hak akses admin untuk {$user->name} berhasil dicabut.");
    }

    public function updatePermissions(Request $request, $id)
    {
        $user = User::findOrFail($id);

        if ($user->isSuperadmin()) {
            return back()->with('error', 'Hak akses Superadmin utama tidak dapat diubah.');
        }

        // Jika tidak ada yang dicentang, simpan array kosong
        $user->update(['permissions' => $request->input('permissions', [])]);

        return back()->with('success', 'Hak akses untuk ' . $user->name . ' berhasil diperbarui!');
    }

    public function toggleRegisterStatus()
    {
        $newStatus = Setting::get('allow_register', '1') == '1' ? '0' : '1';

        Setting::set('allow_register', $newStatus);

        $pesan = $newStatus == '1'
            ? 'Pendaftaran pegawai berhasil DIBUKA.'
            : 'Pendaftaran pegawai berhasil DIKUNCI.';

        return back()->with('success', $pesan);
    }

    // =========================================================================
    // DOKUMEN PEGAWAI
    // =========================================================================

    // Level 1: daftar pegawai
    public function documentsIndex(Request $request)
    {
        if (!Auth::user()->hasPermission('manage_documents')) {
            abort(403, 'Anda tidak memiliki hak akses untuk mengelola dokumen pegawai.');
        }

        $query = User::withCount('documents');

        $this->applySearch($query, $request);
        $this->orderByRoleHierarchy($query);

        $users = $query->get();

        return view('admin.documents.index', compact('users'));
    }

    // Level 2: folder bulan milik pegawai tertentu
    public function userFolders($userId)
    {
        $user = User::findOrFail($userId);

        $folders = Document::where('user_id', $user->id)
            ->select('bulan_periode', 'tahun_periode')
            ->groupBy('bulan_periode', 'tahun_periode')
            ->get();

        return view('admin.documents.folders', compact('user', 'folders'));
    }

    // Level 3: isi file di dalam folder bulan
    public function monthFiles($userId, $bulan)
    {
        $user = User::findOrFail($userId);

        $documents = Document::where('user_id', $user->id)
            ->where('bulan_periode', $bulan)
            ->latest()
            ->get();

        return view('admin.documents.files', compact('user', 'bulan', 'documents'));
    }

    public function storeDocumentForUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        $request->validate([
            'kategori'        => 'required|in:data_dukung,rekap_presensi',
            'tanggal_mulai'   => 'nullable|required_if:kategori,data_dukung|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan'      => 'required|string',
            'lampiran'        => 'required|array',
            'lampiran.*'      => 'file|mimes:pdf,jpg,jpeg,png|max:5048',
        ]);

        $periode = $this->resolvePeriode($request);

        foreach ($request->file('lampiran') as $file) {
            $fileName = $file->getClientOriginalName();

            // Simpan ke storage privat, dirapikan per tahun/bulan
            $path = $file->storeAs(
                "documents/{$periode['tahun']}/{$periode['bulan']}",
                time() . '_' . $fileName,
                'local'
            );

            Document::create([
                'user_id'       => $user->id,
                'kategori'      => $request->kategori,
                'tanggal'       => $periode['tanggal'],
                'keterangan'    => $periode['keterangan'],
                'file_path'     => $path,
                'file_name'     => $fileName,
                'bulan_periode' => $periode['bulan'],
                'tahun_periode' => $periode['tahun'],
                'share_token'   => Str::random(40), // Permanent shared token untuk aplikasi pusat
            ]);
        }

        return back()->with('success', 'Dokumen berhasil di-upload ke folder ' . $user->name);
    }

    public function previewFile($id)
    {
        $document = Document::findOrFail($id);

        if (Storage::disk('local')->exists($document->file_path)) {
            return response()->file(Storage::disk('local')->path($document->file_path));
        }

        // Fallback untuk file lama yang tersimpan di disk 'public'
        if (Storage::disk('public')->exists($document->file_path)) {
            return response()->file(Storage::disk('public')->path($document->file_path));
        }

        abort(404, 'File dokumen tidak ditemukan.');
    }

    public function editDocument($id)
    {
        $document = Document::with('user')->findOrFail($id);

        return view('admin.documents.edit', compact('document'));
    }

    public function updateDocument(Request $request, $id)
    {
        $document = Document::findOrFail($id);

        $request->validate([
            'keterangan' => 'required|string',
            'file'       => 'nullable|file|mimes:pdf,png,jpg,jpeg|max:10240',
        ]);

        $data = ['keterangan' => $request->keterangan];

        if ($request->hasFile('file')) {
            $this->deleteStoredFile($document);

            $file = $request->file('file');
            $data['file_name'] = $file->getClientOriginalName();
            $data['file_path'] = $file->store('documents', 'local');
        }

        $document->update($data);

        return $this->redirectToFiles($document, 'Dokumen berhasil diperbarui.');
    }

    public function destroyDocument($id)
    {
        $document = Document::findOrFail($id);

        $this->deleteStoredFile($document);
        $document->delete();

        return $this->redirectToFiles($document, 'Dokumen berhasil dihapus.');
    }

    // =========================================================================
    // HELPER PRIVATE
    // =========================================================================

    /** Filter pencarian berdasarkan nama, NIP, atau email. */
    private function applySearch(Builder $query, Request $request): Builder
    {
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('nip', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query;
    }

    private function applyRoleFilter(Builder $query, Request $request): Builder
    {
        if ($request->filled('role') && in_array($request->role, self::ROLES)) {
            $query->where('role', $request->role);
        }

        return $query;
    }

    private function applySort(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'name_asc'  => $query->orderBy('name', 'asc'),
            'name_desc' => $query->orderBy('name', 'desc'),
            default     => $this->orderByRoleHierarchy($query),
        };
    }

    private function orderByRoleHierarchy(Builder $query): Builder
    {
        return $query
            ->orderByRaw("FIELD(role, 'superadmin', 'admin', 'pegawai') ASC")
            ->orderBy('name', 'asc');
    }

    private function resolvePeriode(Request $request): array
    {
        if ($request->kategori === 'rekap_presensi') {
            $today = Carbon::now();
            $ref = $today->day <= 25 ? $today->copy()->subMonth() : $today->copy();

            return [
                'bulan'      => self::BULAN[$ref->month],
                'tahun'      => $ref->year,
                'tanggal'    => $today->format('Y-m-d'),
                'keterangan' => '[REKAP PRESENSI] ' . $request->keterangan,
            ];
        }

        // Data dukung: tanggal_mulai menentukan folder
        $start = Carbon::parse($request->tanggal_mulai);
        $keterangan = $request->keterangan;

        if ($request->tanggal_selesai && $request->tanggal_selesai !== $request->tanggal_mulai) {
            $end = Carbon::parse($request->tanggal_selesai);
            $keterangan = "(Izin Tgl {$start->format('d/m/Y')} s/d {$end->format('d/m/Y')}) " . $keterangan;
        }

        return [
            'bulan'      => self::BULAN[$start->month],
            'tahun'      => $start->year,
            'tanggal'    => $start->format('Y-m-d'),
            'keterangan' => $keterangan,
        ];
    }

    private function deleteStoredFile(Document $document): void
    {
        if ($document->file_path && Storage::disk('local')->exists($document->file_path)) {
            Storage::disk('local')->delete($document->file_path);
        }
    }

    private function redirectToUsers(string $type, string $message)
    {
        return redirect()->route('admin.users.index')->with($type, $message);
    }

    private function redirectToFiles(Document $document, string $message)
    {
        return redirect()->route('admin.documents.files', [
            'userId' => $document->user_id,
            'bulan'  => $document->bulan_periode,
        ])->with('success', $message);
    }
}