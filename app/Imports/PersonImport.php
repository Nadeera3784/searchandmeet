<?php

namespace App\Imports;

use App\Models\Business;
use Illuminate\Support\Collection;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\SkipsErrors;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Carbon\Carbon;

class PersonImport implements ToModel, WithStartRow, WithValidation, SkipsOnFailure{

    use Importable, SkipsFailures;

    private $repository;
    private $businessRepository;

    public $countImports = 0;

    public $countFailures = 0;
    
    public function __construct($repository, $businessRepository){
        $this->repository = $repository;
        $this->businessRepository = $businessRepository;
    }
    

    public function startRow(): int{
        return 2;
    }

    public function onFailure(Failure ...$failures){ 
        $this->countFailures++;
    }

    public function rules(): array{
        return [
            '5'  => 'unique:people,email',
            '4'  => 'required',
            '7'  => 'required_with:phone_code_id',
            '1'  => 'required',
            '10' => 'nullable|string',
            '3'  => 'required|string',
            '6'  => 'required',
            '23' => 'required',
            '24' => 'required',
            '25' => 'required',
            '26' => 'required|in:yes,no',
            '27' => 'nullable',
            '31' => 'string|nullable|digits:4|max:' . (date("Y") + 1),
            '32' => 'string|nullable',
            '33' => 'integer|nullable',
            '34' => 'integer|nullable',
            '35' => 'string|nullable',
            '36' => 'string|nullable',
            '28' => 'url|nullable',
            '29' => 'url|nullable',
            '30' => 'url|nullable',
            '37' => 'required',
            '38' => 'required',
            '39' => 'required',
        ];
    }

    public function getCountImports(): int{
        return $this->countImports;
    }

    public function getCountFailures(): int{
        return $this->countFailures;
    }

    public function model(array $row){



        // if (!isset($row[1] || isset($row[2])) {
        //    return null;
        // }

         $this->countImports++;


        $data = [
            'agent_id'          => $row[0],
            'designation'       => $row[1],
            'status'            => $row[2],
            'timezone_id'       => $row[3],
            'name'              => $row[4],
            'email'             => $row[5],
            'country_id'        => $row[6],
            'phone_number'      => $row[7],
            'looking_for'       => $row[10],
            'source'            => $row[17], 
            'country_id'        => $row[22],
            'type_id'           => $row[23],
            'company_type_id'   => $row[24],
            'business_name'     => $row[25],
            'current_importer'  => $row[26],
            'phone'             => $row[27],
            'website'           => $row[28], 
            'linkedin'          => $row[29],
            'facebook'          => $row[30],
            'founded_year'      => $row[31],
            'HQ'                => $row[32],
            'employee_count'    => $row[33],
            'annual_revenue'    => $row[34],
            'sic_code'          => $row[35],
            'naics_code'        => $row[36],
            'address'           => $row[37],
            'city'              => $row[38],
            'state'             => $row[39],
        ];


        $person = $this->repository->create(
            array_merge($data, [
                'source' => 'agent'
        ]), auth('agent')->user()->id);

        if($person) {
            $business = $this->businessRepository->create($data, $person);
        }

       return $person;
    }
}