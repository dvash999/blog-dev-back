<?php

namespace App\Models;

use App\Transformers\PostTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    protected $fillable = ['title', 'author', 'content', 'type' ];


    public $transformer = PostTransformer::class;

    public static function getAllPosts($filter)
    {
        if ($filter) {
            return DB::table('posts')->where('type', $filter)->get();
        } else {
            return DB::table('posts')->get();
        }
    }

    public static function storePost($post)
    {
        return DB::transaction(function () use ($post) {
            $imgName = $post['img']->getClientOriginalName();
            $post['img']->move('img', $imgName);
            $post = new self($post['data']);
            $post->img_title = $imgName;
            return $post->save();
        });
    }

    public static function showPost($id)
    {
        return self::where('id', $id)->first();
    }

    public static function getPost($id)
    {
        return self::where('id', $id)->first();
    }

    public static function updatePost($id, $post)
    {
//        $isSaved = DB::transaction(function () use ($id, $post) {
//            $oldPost = self::find($id);
//            foreach ($post as $key => $value) {
//                $oldPost[$key] = $post[$key];
//            }
//
//            $oldPost->save();
//            return true;
//        });
//
//        if ($isSaved) {
//            return response()->json(['message' => 'success', 'status' => 200]);
//        } else {
//            return response()->json(['message' => 'failed', 'status' => 401]);
//        }
    }

    public static function deletePost($id)
    {
        try {
            return Post::destroy($id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response(['message' => 'failed', 'extra' => 'couldnt delete post'], 400);
        }
    }


}
