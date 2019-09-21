<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        $post = Post::all();
        return response()->json(['data' => $post], 200);
    }


    public function store(Request $request)
    {
        return Post::storePost($request->post());
    }

    public function show($id)
    {
        return Post::showPost($id);
    }


    public function update(Request $request, $id)
    {
       return Post::updatePost($id, $request->all());
    }

    public function destroy($id)
    {
        return Post::deletePost($id);
    }
}
