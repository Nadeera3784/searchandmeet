<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\ApiController;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends ApiController
{
    public function index(Request $request)
    {
        $categories = Category::all();
        return $this->sendResponse('success', ['categories' => $categories], 200);
    }

    public function searchCategory(Request $request){
        $categories = Category::query();

        if($request->has('q')){
            $search = $request->q;
            $categories = Category::where('name', 'LIKE', "%$search%");
        }

        $categories = $categories->limit(50)->get();
        return response()->json($categories, 200);
    }

    public function findCategoryByID($id){
       $category = Category::where('id', $id)->first();
       return $this->sendResponse('success', ['category' => $category], 200);
    }

}
