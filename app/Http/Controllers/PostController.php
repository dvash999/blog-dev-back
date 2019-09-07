<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Post;

class PostController extends Controller
{
    public function index()
    {
        return Post::getAllPosts();
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
