<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends ApiController
{
    public function index(Request $request)
    {
        $languages = Language::all();
        return $this->sendResponse('success', ['languages' => $languages], 200);
    }

}
