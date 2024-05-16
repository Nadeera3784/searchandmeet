<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use App\Models\Metric;
use Illuminate\Http\Request;

class MetricController extends ApiController
{
    public function index(Request $request)
    {
        $metrics = Metric::all();
        return $this->sendResponse('success', ['metrics' => $metrics], 200);
    }

}
