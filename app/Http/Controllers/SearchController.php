<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class SearchController extends Controller
{
    public static function searchPosts($query)
    {
        try {
            // TODO - add validation to $query;
            return DB::table('posts')
                ->where('title', 'LIKE', '%' . $query . '%')
                ->orWhere('author', 'LIKE', '%' . $query . '%')
                ->orWhere('content', 'LIKE', '%' . $query . '%')
                ->get();
        } catch (\Exception $e) {
            return $e;
        }
    }
}
