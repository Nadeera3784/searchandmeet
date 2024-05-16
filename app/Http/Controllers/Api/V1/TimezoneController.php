<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\TimeZone;
use Illuminate\Http\Request;

class TimezoneController extends ApiController
{
    public function index(Request $request)
    {
        $timezones = TimeZone::all();
        return $this->sendResponse('success', ['timezones' => $timezones], 200);
    }

}
