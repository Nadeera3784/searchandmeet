<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\PricePercentage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DomainPricesTableSeeder extends Seeder
{
    public function run()
    {
        $countries = array(
            array('domain' => 'default', 'percentage' => '100'),
            array('domain' => config('domain.identifiers.china'), 'percentage' => '300'),
        );

        DB::table('domain_pricing')->insert($countries);
    }
}
