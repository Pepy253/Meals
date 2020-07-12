<?php

namespace App\Http\Controllers;

use App\Helpers\QueryHelper;
use App\Helpers\ValidationHelper;
use App\Http\Requests\MealsRequest;
use App\Http\Resources\MealCollection;

class MealController extends Controller
{

    public function show(MealsRequest $request)
    {
        app()->setLocale($request->lang);
        
        $meals = QueryHelper::getCollection($request);
            
        $response = new MealCollection($meals);
    
        if ($request->page > $meals->lastPage()) {
            $error =  'Requested page does not exist! Last page for the current search is page '. $meals->lastPage();
            
            return response()
                ->json(['page' => $error], 400, [], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
        }
        
        return response()
            ->json($response, 200, [], JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }
}
