<?php

namespace App\Imports;

use App\Models\NaicCode;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\Importable;

class NaicCodeImport implements ToModel, WithStartRow{

    use Importable;

    public function startRow(): int{
        return 3;
    }

    public function model(array $row){

        $naic_code = NaicCode::create([
            'code'     => $row[1],
            'name'     => $row[2],
        ]);

        return $naic_code;
    }
}