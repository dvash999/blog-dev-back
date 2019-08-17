<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    public static function getAllPosts()
    {
        return self::all();
    }

    public static function storePost($post)
    {
        $isSaved = DB::transaction(function () use ($post) {
                    $newPost = new Post;
                    foreach ($post as $key => $value) {
                        $newPost[$key] = $post[$key];
                    }
                    $newPost->save();
                    return true;
                });

        if ($isSaved) {
            return response()->json(['message' => 'success', 'status' => 200]);
        } else {
            return response()->json(['message' => 'failed', 'status' => 401]);
        }

    }

    public static function showPost($id)
    {
        return self::where('id', $id)->first();
    }

    public static function updatePost($id, $post)
    {
        $isSaved = DB::transaction(function () use ($id, $post) {
            $oldPost = self::find($id);
            foreach ($post as $key => $value) {
                $oldPost[$key] = $post[$key];
            }

            $oldPost->save();
            return true;
        });

        if ($isSaved) {
            return response()->json(['message' => 'success', 'status' => 200]);
        } else {
            return response()->json(['message' => 'failed', 'status' => 401]);
        }
    }

    public static function deletePost($id)
    {
        $postToDelete = self::find($id);
        return $postToDelete->delete() ? 'deleted successfully' : 'failed';
    }


}
