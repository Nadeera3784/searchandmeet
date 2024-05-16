<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Category extends Model
{
    use QueryCacheable;
    use HasFactory;

    public $cacheTags = ['category'];
    public $cachePrefix = 'category_';
    protected $appends = ['treeName'];

    public function children(){
        return $this->hasMany( Category::class, 'parent', 'id' );
    }

    public function parentCategory(){
        return $this->hasOne( Category::class, 'id', 'parent' );
    }

    public function getTreeNameAttribute(){
        $name_string = $this->name;
        $parent = $this->parentCategory;
        while($parent !== null)
        {
            $name_string = $parent->name . ' > ' . $name_string;
            $parent = $parent->parentCategory;
        }

        return $name_string;
    }

    public static function childCategories($id){
        $level_one = Category::where('parent', $id)->pluck('id');
        $children = $level_one->toArray();
        foreach ($level_one as $item) {
            $nested_levels = Category::childCategories($item);
            $children = array_merge($children, $nested_levels);
        }

        return $children;
    }
}
