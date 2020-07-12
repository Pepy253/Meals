<?php

namespace App\Helpers;

use App\Category;

class ValidationHelper
{
    public static function getValidCategories()
    {
        $categories = Category::select('id')->orderBy('id', 'asc')->get()->toArray();

        foreach ($categories as $category) {
            $validCategory[] = $category['id'];
        }
        
        array_push($validCategory, 'null', '!null');

        return $validCategory;
    }
}
