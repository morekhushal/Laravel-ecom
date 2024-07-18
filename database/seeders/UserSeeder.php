<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\User;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records= [
            [
                'name' => 'Khushal',
                'email' => 'kbm@user.com',  
                'password' => Hash::make('123')
            ],
            [
                'name' => 'Ajay',
                'email' => 'ajay@user.com',
                'password' => Hash::make('123')
            ]
        ];
        User::insert($records);
    }
}
