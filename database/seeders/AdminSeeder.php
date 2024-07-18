<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Admin;
use Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records= [
            [
                'name' => 'Khushal',
                'email' => 'kbm@admin.com',
                'password' => Hash::make('123')
            ],
            [
                'name' => 'Ajay',
                'email' => 'ajay@admin.com',
                'password' => Hash::make('123')
            ]
        ];
        Admin::insert($records);
    }
}
