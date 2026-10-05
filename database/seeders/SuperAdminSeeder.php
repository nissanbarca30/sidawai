<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name'     => 'Super Administrator',
            'email'    => 'superadmin@sidawai.go.id',
            'nip'      => '1234567890',
            'password' => Hash::make('password123'),
            'role'     => 'superadmin',
        ]);
    }
}
