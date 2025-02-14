<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('websettings')->insert([
            [
                'slug' => 'logo',
                'urut' => 1,
                'heading' => 'Logo Web',
                'content' => null,
                'type' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'nama_web',
                'urut' => 2,
                'heading' => 'Nama Web',
                'content' => null,
                'type' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'slug' => 'meta_desc',
                'urut' => 3,
                'heading' => 'Meta Description',
                'content' => null,
                'type' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
