<?php

namespace App\Console\Commands;

use App\Enums\Person\AccountSourceTypes;
use App\Models\PurchaseRequirement;
use App\Repositories\PurchaseRequirement\PurchaseRequirementRepositoryInterface;
use Illuminate\Console\Command;

class PurchaseRequirementUpdateTitle extends Command{

    protected $signature = 'pr:update_title';

    protected $description = 'Generate suffix for purchase requirement';

    public function __construct(){
        parent::__construct();
    }

    public function handle(PurchaseRequirementRepositoryInterface $purchaseRequirementRepository){

        // TODO single query

        $purchase_requirements = PurchaseRequirement::with('person')->get();

        $purchase_requirements_by_source = [];

        foreach($purchase_requirements as $key => $pr){

            if($pr->person->source === AccountSourceTypes::Api){    
                array_push($purchase_requirements_by_source, $pr);
            }
        };

       if($purchase_requirements_by_source){
            foreach($purchase_requirements_by_source as $prs){
                $prequirement =  PurchaseRequirement::find($prs->id);
                $prequirement->suffix =  $purchaseRequirementRepository->suffixGenerator();
                $prequirement->save();
            } 
       }

       $this->info('Title suffix has been updated successfully');

    }

}