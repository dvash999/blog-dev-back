<?php

namespace App\Http\Controllers;

use function GuzzleHttp\Psr7\get_message_body_summary;
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

        $this->validate($request, $rules);
        $post = $request->all();

        try {
            Post::storePost($post);
        } catch (\Exception $e) {
            return $e;
        }

        //return response()->json(['message' => $isSaved ? 'success' : 'failed', 'status' => $isSaved ? 200 : 401]);

        return Response(['status' => 200, 'message' => 'Post saved!']);
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
