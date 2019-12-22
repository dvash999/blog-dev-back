<?php

namespace App\Http\Controllers;

use App\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class likeController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $type = $request->post('type');
        $id = $request->post('typeID');

        try {
            DB::table($type . 's')->where('id', $id)->increment('likes', 1);
        } catch (\Exception $e) {
            dd($e);
        }

        return response(['message' => 'success']);
    }


    public static function getLikesByTypeAndId($type, $typeID)
    {
        $likes = 0;

        try {
            $likes = DB::table($type . 's')->where('id', $typeID)->value('likes');
        } catch (\Exception $e) {
            dd($e);
        }

        return $likes;
    }


    public function show($id)
    {
    }



    public function edit($id)
    {
        //
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
