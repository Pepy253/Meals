<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Meal;
use App\Category;
use App\Tag;
use App\Ingredient;

class QueryHelper
{
    public static function getCollection(Request $request)
    {
        
        $perPage = $request->per_page ?? 5;
                    
        $meals = Meal::when(request('diff_time') > 0, function ($query) {
            return $query->select(
                'id',
                'category_id',
                \DB::raw('(CASE
                    WHEN UNIX_TIMESTAMP(meals.deleted_at) > '. request('diff_time') .' THEN "deleted"  
                    WHEN UNIX_TIMESTAMP(meals.updated_at) > '. request('diff_time') .' THEN "updated"
                    WHEN UNIX_TIMESTAMP(meals.created_at) > '. request('diff_time') .' THEN "created"
                    ELSE "null" 
                    END) AS status')
            );
        })
            ->when(request('diff_time') == null, function ($query) {
                return $query->select('id', 'category_id');
            })
            ->when(in_array('category', $request->with), function ($query) {
                return $query->with(['category' => function ($query) {
                    $query->select('id', 'slug');
                }]);
            })
            ->when(in_array('tags', $request->with), function ($query) {
                return $query->with(['tags' => function ($query) {
                    $query->select('id', 'slug');
                }]);
            })
            ->when(in_array('ingredients', $request->with), function ($query) {
                return $query->with(['ingredients' => function ($query) {
                    $query->select('id', 'slug');
                }]);
            })
            ->when(request('category') === 'null', function ($query) {
                return $query->whereNull('category_id');
            })
            ->when(request('category') != 'null'
                && request('category') != null
                && request('category') != '!null', function ($query) {
                    return $query->where('category_id', '=', request('category'));
                })
            ->when(request('category') === '!null', function ($query) {
                return $query->whereNotNull('category_id');
            })
            ->when(count(explode(',', request('tags'))) > 1, function ($query) {
                return $query->join('meal_tags as mt', 'meal_id', '=', 'id')
                ->whereIn('mt.tag_id', explode(',', request('tags')))
                ->havingRaw("COUNT('tag.tag_id') = " . count(explode(',', request('tags'))))
                ->groupBy('id', 'category_id', 'deleted_at', 'updated_at', 'created_at');
            })
            ->when(count(explode(',', request('tags'))) == 1
                && request('tags') != null, function ($query) {
                    return  $query->join('meal_tags as mt', 'meal_id', '=', 'id')
                    ->where('mt.tag_id', request('tags'));
                })
            ->when(request('diff_time') > 0, function ($query) {
                return $query->withTrashed();
            })
            ->paginate($perPage);

        
        return $meals;
    }
}
