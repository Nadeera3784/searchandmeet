<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\SaicCodeImport;

class SaicCodesSeeder extends Seeder{

    public function run(){
        $file = resource_path() . '/codes/saic.xlsx';
        $import_instance  = new SaicCodeImport();
        $import_instance->import($file);
    }
}
