<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use mysql_xdevapi\Exception;


class PostController extends ApiController
{
    public function index(Request $request)
    {
        $posts = Post::getAllPosts($request->get('filter'));
        foreach ($posts as $post) {
            $post->img = self::getAndTransformImage($post->img_title);
        }
        return $this->showAll($posts);
    }

    public function show(Post $post)
    {
        if($post) {
            $post->date = self::transformDate($post->value('date'));
            $post->img = self::getAndTransformImage($post->img_title);
            return response(['status' => 200, 'message' => 'success', 'payload' => $post]);
        } else {
            return response(['status' => 401, 'message' => 'failed', 'payload' => $post]);
        }
    }

    public function getAndTransformImage($imgTitle)
    {
        $images = File::files(public_path().'/img');
        foreach($images as $image) {
            if($image->getFileName() === $imgTitle) {
                return base64_encode(file_get_contents($image));
            }
        }
    }


    public function getImageFromRequest($request)
    {
        return $request->file('img');
    }

    public function processPostContent($request)
    {
        return json_decode($request->post('data'),true);
    }

    public function store(Request $request)
    {
        $post = self::processPost($request);
        self::validatePost($post);
        try {
            Post::storePost($post);
            return response(['status' => 200, 'message' => 'success']);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['status' => 401, 'message' => 'failed']);

        }
    }

    public function processPost($request)
    {
        $post = self::processPostContent($request);
        $img = self::getImageFromRequest($request);
        return ['data' => $post, 'img' => $img];
    }

    public function validatePost($post)
    {
        // TODO - define deep-dive && news
        $rules = [
                'data.title' => ['string','required','max:100'],
                'data.author' => ['string','required','max:50'],
                'data.type' => ['string', 'required'],
                'data.content' => ['string','required','max:3000'],

            'img' => ['required', 'mimes:jpg,jpeg,png,bmp', 'max:20000']
        ];

        Validator::make($post, $rules)->validate();

    }

    public function transformDate($data)
    {
    $dateArr = explode('-', $data);
    return "{$dateArr[2]}.{$dateArr[2]}.{$dateArr[0]}";
    }

    public function update(Request $request, $postId)
    {
        $post = self::processPost($request);
        self::validatePost($post);
        try {
            Post::deletePost($postId);
            Post::storePost($post);
            return response(['message' => 'success'], 200);

        } catch (\Exception $e) {
            DB::rollback();
            return response(['status' => 401, 'message' => 'failed']);

        }
    }

    public function destroy($post)
    {
        Post::deletePost($post);
        return response(['message' => 'success', 'payload' => Post::all()], 200);
    }
}
