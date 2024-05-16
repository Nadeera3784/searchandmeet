<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends ApiController
{
    public function index(Request $request)
    {
        $country = Country::all();
        return $this->sendResponse('success', ['country' => $country], 200);
    }

}
