<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Helpers\QueryHelper;
use App\Helpers\ValidationHelper;

class MealController extends Controller
{

    public function test(Request $request)
    {   
        app()->setLocale($request->lang ?? 'en');
        return ValidationHelper::getValidation($request); 
    }
}
