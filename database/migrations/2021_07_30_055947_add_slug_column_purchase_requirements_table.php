<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\PurchaseRequirement;

class AddSlugColumnPurchaseRequirementsTable extends Migration{

    public function up(){
       
        Schema::table('purchase_requirements', function (Blueprint $table) {
            $table->string('slug')->nullable();
        });

        foreach(PurchaseRequirement::all() as $purchase_requirement){
            $name = $purchase_requirement->product;
            $slug = Str::slug($name, '-');

            
            foreach(PurchaseRequirement::all() as $prq){
                if($prq->slug == $slug){
                    $slug =  Str::slug($name, '-').Str::random(4);
                }
            }

            $PR = PurchaseRequirement::find($purchase_requirement->id);
            $PR->slug =  $slug;
            $PR->save();

        }


    }


    public function down(){
        
    }
}
