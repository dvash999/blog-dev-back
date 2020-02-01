<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Http\UploadedFile;

class PostController extends ApiController
{
    public function index(Request $request)
    {
        $posts = Post::getAllPosts($request->get('filter'));
        return $this->showAll($posts);
    }


    public function store(Request $request)
    {
//        $rules = [
//            'author' => 'required',
//            'title' => 'required',
//            'type' => 'required',
//            'content' => 'required',
//            'date' => 'date',
//            'img' => 'required'
//        ];

//        $this->validate($request, $rules);
        $post = $request->all();
        dd($post);
        dd($request->hasFile('img'));

        if(Post::storePost($post)) {
            return response(['status' => 200, 'message' => 'success']);
        } else {
            return response(['status' => 401, 'message' => 'failed']);
        }
    }

    public function show(Post $post)
    {
        if($post) {
            $post->date = self::transformDate($post->value('date'));

            return response(['status' => 200, 'message' => 'success', 'payload' => $post]);
        } else {
            return response(['status' => 401, 'message' => 'failed', 'payload' => $post]);
        }
    }

    public function transformDate($data)
    {
    $dateArr = explode('-', $data);
    return "{$dateArr[2]}.{$dateArr[2]}.{$dateArr[0]}";
    }


    public function update(Request $request, Post $post)
    {
        $rules = [
            'author' => 'required',
            'title' => 'required',
            'type' => 'required',
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
       return $post->delete() ? response(['message' => Post::all()]) : response(['message' => false]);
    }
}
