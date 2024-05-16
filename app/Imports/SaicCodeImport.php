<?php

namespace App\Imports;

use App\Models\SaicCode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;

class SaicCodeImport implements ToModel, WithStartRow{

    use Importable;


    public function startRow(): int{
        return 3;
    }

    public function model(array $row){

        $saic_code = SaicCode::create([
            'code'     => $row[0],
            'name'     => $row[1],
        ]);

        return $saic_code;
    }
}