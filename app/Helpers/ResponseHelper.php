<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class ResponseHelper
{
    public static function getResponse($meals)
    {
        $response = [
            'meta'  => [
                'currentPage' => $meals->currentPage(),
                'totalItems'  => $meals->total(),
                'itemsPerPage'=> $meals->perPage(),                    
                'totalPages'  => $meals->lastPage(),
            ],
            'data'  => $meals->items(),
            'links' => [
                'prev' => $meals->previousPageUrl(),
                'next' => $meals->nextPageUrl(),
                'self' => $meals->url($meals->currentPage()),                   
            ],
        ];
        
        return response()->json($response, 200, array(), JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES|JSON_PRETTY_PRINT);
    }
}