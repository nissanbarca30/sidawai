<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kategori',
        'tanggal',
        'keterangan',
        'file_path',
        'file_name',
        'bulan_periode',
        'tahun_periode',
        'share_token',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($document) {
            if (empty($document->share_token)) {
                $document->share_token = Str::random(40);
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}