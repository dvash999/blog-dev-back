<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends ApiController
{
    public function index()
    {
        $post = Post::all();
        return $this->showAll($post);
    }


    public function store(Request $request)
    {
        $rules = [
            'author' => 'required',
            'title' => 'required',
            'content' => 'required',
            'date' => 'date',
        ];

        $this->verified($request, $rules);

        $data = $request->all();
        $post = $data->create();

        return $this->showOne($post);
    }

    public function show(Post $post)
    {
        return $this->showOne($post);
    }


    public function update(Request $request, Post $post)
    {
        $rules = [
            'author' => 'required',
            'title' => 'required',
            'content' => 'required',
            'date' => 'date',
        ];

        $this->validate($request, $rules);
        $newPostData = $request->post();

        foreach($newPostData as $key => $value) {
            if (!$value) {
                $this->errorResponse('cant accept empty values', 401);
            }
            $post[$key] = $value;
        }

        $post->save();

        return $this->showOne($post);
    }

    public function destroy(Post $post)
    {
        $post->delete();

        return $this->showOne($post);
    }
}
