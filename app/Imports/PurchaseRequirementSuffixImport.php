<?php

namespace App\Imports;

use League\Csv\Reader;

class PurchaseRequirementSuffixImport {

    private $file;

    public function __construct($file){
        $this->file = $file;
    }


    public function convertCsvToArray(){
      $csv = Reader::createFromPath($this->file)->setHeaderOffset(0);
      return  $csv;
    }

}