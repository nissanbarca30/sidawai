<!DOCTYPE html>
<html>
<head>
    <title>Rekap Data Dokumen Presensi - {{ $bulan }} {{ $tahun }}</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #40BF89; padding-bottom: 10px; }
        .header h2 { margin: 0; color: #111; text-transform: uppercase; font-size: 16px; }
        .header p { margin: 4px 0 0; color: #555; font-weight: bold; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #777; padding: 7px; text-align: left; vertical-align: middle; }
        th { background-color: #40BF89; color: white; text-transform: uppercase; font-size: 10px; letter-spacing: 0.5px; }
        tr:nth-child(even) { background-color: #f9f9f9; }
        .badge-dd {
            color: #047857;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }
        .badge-rp {
            color: #1d4ed8;
            font-weight: bold;
            text-transform: uppercase;
            font-size: 9px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>REKAP DOKUMEN PRESENSI PEGAWAI</h2>
        <p>BKK KELAS I PONTIANAK - PERIODE {{ strtoupper($bulan) }} {{ $tahun }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">NO</th>
                <th style="width: 20%;">NAMA PEGAWAI</th>
                <th style="width: 15%; text-align: center;">KATEGORI</th>
                <th style="width: 18%;">TGL DOKUMEN</th>
                <th style="width: 22%;">KETERANGAN</th>
                <th style="width: 20%;">FILE LAMPIRAN</th>
            </tr>
        </thead>
        <tbody>
            @forelse($documents as $index => $doc)
                <tr>
                    <td style="text-align: center; font-weight: bold;">{{ $index + 1 }}</td>
                    <td style="font-weight: bold;">{{ $doc->user->name }}</td>
                    
                    <!-- Kolom Kategori Baru -->
                    <td style="text-align: center;">
                        @if(($doc->kategori ?? 'data_dukung') === 'rekap_presensi')
                            <span class="badge-rp">Rekap Presensi</span>
                        @else
                            <span class="badge-dd">Data Dukung</span>
                        @endif
                    </td>

                    <!-- Tanggal -->
                    <td>{{ \Carbon\Carbon::parse($doc->tanggal)->translatedFormat('d F Y') }}</td>
                    
                    <!-- Keterangan (Bersih dari prefix) -->
                    <td>{{ str_replace('[REKAP PRESENSI] ', '', $doc->keterangan) }}</td>
                    
                    <!-- Nama File -->
                    <td style="word-break: break-all; font-size: 10px;">{{ $doc->file_name }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center; font-weight: bold; color: #777; padding: 20px;">
                        Tidak ada data dokumen pada periode ini.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>