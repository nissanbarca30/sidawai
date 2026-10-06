<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Notifications\ResetPassword as ResetPasswordNotification;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'nip',
        'email',
        'password',
        'role',
        'permissions',
        'ai_provider',
        'ai_model',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'permissions' => 'array',
    ];

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    public function documents()
    {
        return $this->hasMany(Document::class, 'user_id', 'id');
    }

    public function isSuperadmin()
    {
        return $this->role === 'superadmin';
    }

    public function isAdmin()
    {
        return in_array($this->role, ['superadmin', 'admin']);
    }

    public function isPegawai()
    {
        return $this->role === 'pegawai';
    }

    public function hasPermission($permissionKey)
    {
        // Superadmin punya semua akses secara otomatis
        if ($this->isSuperadmin()) {
            return true;
        }

        // Jika bukan admin biasa, tidak punya akses admin
        if (!$this->isAdmin()) {
            return false;
        }

        // Jika permissions belum diset (null), beri akses default true atau cek array
        if (is_null($this->permissions)) {
            return true; // Default admin baru dapat semua akses
        }

        return in_array($permissionKey, $this->permissions);
    }
}
