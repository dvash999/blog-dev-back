<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use function GuzzleHttp\Psr7\get_message_body_summary;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends ApiController
{
    public function index(Request $request)
    {
        $posts = Post::getAllPosts($request->get('filter'));
        return $this->showAll($posts);
    }


    public function store(Request $request)
    {
        $rules = [
            'author' => 'required',
            'title' => 'required',
            'type' => 'required',
            'content' => 'required',
            'date' => 'date',
        ];

        $this->validate($request, $rules);
        $post = $request->all();

        Post::storePost($post) ?  Helper::success() : Helper::failed();
    }

    public function show(Post $post)
    {
        // TODO use validation for the ID in the request
//        $this->showOne($post);

        if ($post) {
            return Response(['message' => $post, 'status' => 200, ]);
        } else {
            return Response(['message' => null, 'status' => 404]);
        }
//        return $this->showOne($post);
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
