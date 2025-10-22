<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{

    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin', // <-- ตั้ง username
            'email' => null, // หรือใส่อีเมลก็ได้
            'password' => Hash::make('12345678'), // <-- ตั้งรหัสผ่าน
        ]);
    }
}
