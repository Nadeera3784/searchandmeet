<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Imports\NaicCodeImport;

class NaicCodesSeeder extends Seeder{

    public function run(){
        $file = resource_path() . '/codes/naic.xlsx';
        $import_instance  = new NaicCodeImport();
        $import_instance->import($file);
    }
}
