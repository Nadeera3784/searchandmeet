<?php

namespace App\Imports;

use App\Models\Category;
use Maatwebsite\Excel\Concerns\ToModel;

class CategoryImport implements ToModel
{
    public function model(array $row)
    {
        return [
            't1' => $row[0],
            't2' => $row[1],
            't3' => $row[2],
        ];
    }
}
