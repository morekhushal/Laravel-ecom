<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use \App\Models\Product;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $records = [
            [
                'title' => 'mobile',
                'qty' => 10,
                'price' => 10000
            ],
            [
                'title' => 'laptop',
                'qty' => 5,
                'price' => 50000
            ],
            [
                'title' => 'tablet',
                'qty' => 20,
                'price' => 20000
            ],
        ];
        Product::insert($records);
    }
}
