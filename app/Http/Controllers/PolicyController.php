<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PolicyController extends Controller
{
    public function terms(Request $request)
    {
        return view('policy.terms', get_defined_vars());
    }

    public function privacy(Request $request)
    {
        return view('policy.privacy', get_defined_vars());
    }

    public function code_of_conduct(Request $request){
        return view('policy.code_of_conduct', get_defined_vars());
    }

    public function doc(Request $request){
        switch($request->language)
        {
            case "en":
                return view('policy.doc.en', get_defined_vars());
        }
    }

    public function marketing(Request $request){
        switch($request->language)
        {
            case "en":
                return view('policy.doc.marketing', get_defined_vars());
        }
    }
}
