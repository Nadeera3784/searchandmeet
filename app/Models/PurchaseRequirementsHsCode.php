<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseRequirementsHsCode extends Model{

    protected $table = "purchase_requirements_hs_codes";

    protected $fillable = [
        'purchase_requirement_id',
        'hs_code_id'
    ];

    public function code(){
        return $this->belongsTo(HsCode::class, 'hs_code_id', 'id');
    }
}
