<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User Admin / Pegawai 1
        User::create([
            'name'     => 'Nafil',
            'nip'      => '6103103005030001',
            'email'    => 'bawang.bombay707@gmail.com',
            'password' => Hash::make('password123'),
        ]);

        // User Pegawai 2
        User::create([
            'name'     => 'Anne Annisa',
            'nip'      => '12345678910',
            'email'    => 'anne.annisa@gmail.com',
            'password' => Hash::make('password123'),
        ]);
    }
}
