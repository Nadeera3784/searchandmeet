<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductPricesTableSeeder extends Seeder
{
    public function run()
    {
        $initalPrices = [
            [
                'product_type' => 1,
                'price' => 100
            ],
            [
                'product_type' => 2,
                'price' => 50
            ],
            [
                'product_type' => 3,
                'price' => 25
            ]
        ];

        foreach($initalPrices as $initalPrice)
        {
            DB::table('product_pricing')->insert($initalPrice);
        }
    }
}
