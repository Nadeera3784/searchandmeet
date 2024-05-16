<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Imports\HsCodeImport;

class HsCodesSeeder extends Seeder{

    public function run(){
        
        $file = resource_path() . '/codes/hs.csv';
        $import_instance  = new HsCodeImport();
        $import_instance->import($file);
    }
}
