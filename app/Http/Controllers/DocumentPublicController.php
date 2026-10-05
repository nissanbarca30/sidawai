<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DocumentPublicController extends Controller
{
    public function previewShared($token)
    {
        $document = Document::where('share_token', $token)->firstOrFail();

        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'Berkas fisik dokumen tidak ditemukan.');
        }

        $fullPath = storage_path('app/' . $document->file_path);
        $mimeType = mime_content_type($fullPath);

        return response()->file($fullPath, [
            'Content-Type' => $mimeType,
            'Content-Disposition' => 'inline; filename="' . $document->file_name . '"'
        ]);
    }
}