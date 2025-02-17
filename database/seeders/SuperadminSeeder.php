<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperadminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Superadmin',
            'username' => 'superadmin',
            'whatsapp' => '0',
            'email' => 'superadmin@mail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole('superadmin');

    }
}
