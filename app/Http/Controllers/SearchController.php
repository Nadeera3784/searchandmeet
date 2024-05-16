<?php

namespace App\Http\Controllers;

use App\Enums\Business\BusinessType;
use App\Enums\Designations\DesignationType;
use App\Models\PurchaseRequirement;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Country;
use Illuminate\Support\Facades\Session;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $cart = Session::get('cart');
        return view('search.index', get_defined_vars());
    }

    public function __get_search_suggestions(Request $request)
    {
        if(!$request->has('q'))
            return [];

        $keyword = $request->q;
        $results = Category::select('name')->where('name', 'like', '%' . urldecode($keyword) . '%');
        
        return $results->pluck('name');
    }
}
