<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Category;
use App\Tag;

class ValidationHelper 
{
    public static function getValidation(Request $request)
    {
        $input = $request->all();
        $tags = Tag::orderBy('id', 'asc')->get();
        $categories = Category::orderBy('id', 'asc')->get();
        foreach($tags as $tag)
        {
            $t[] = $tag->id;
        }
        $t[] = 'null';
        
        $customMessages = array(
            'per_page.min' => 'Meals shown per page cannot be less than 1!',
            'per_page.max' => 'Meals shown per page cannot be more than 200!',
            'per_page.numeric' => 'Per page can only be a numeric value!',
            'lang.exists' => 'Specified language is not supported! Supported languages are English, French and German!',
            'tags.exists' => 'One of the tags you have specified does not exist! Currently existant tags are: ' . implode(', ', $tags->pluck('id')->toArray()),
            'category.in' => 'Specified category does not exist! Currently existant tags are: ' . implode(', ', $t),
            'with.in' => 'Data shown with meals can only be: category, tags and ingredients!',
            'diff_time.integer' => 'diff_time parameter can only be an integer!',
            'diff_time.min' => 'diff_time parameter can only be positive number!'
        );

        $rules = array(
            'per_page' => 'min:1|max:200|numeric',
            'lang' => 'exists:languages,slug',
            'tags' => 'exists:tags,id',
            'category' => Rule::in($t),
            'with' => 'in:("category,tags,ingredients", "category,ingredients,tags", "category,tags", "category,ingredients", "category", "tags,category,ingredients", "tags,ingredients,category", "tags,category", "tags,ingredients", "tags", "ingredients", "ingredients,tags,category", "ingredients,category,tags", "ingredients,tags", "ingredients,category",)',
            'diff_time' => 'integer|min:1',
        );

        $validator = Validator::make($input, $rules, $customMessages);
        if($validator->fails())
        {
            return response()->json($validator->messages(), 400, array(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }
        else
        {
            return QueryHelper::getCollection($request);
        }
    }
}