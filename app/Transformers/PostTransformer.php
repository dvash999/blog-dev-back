<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class PostTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($post)
    {
        return [
            'id' => (int)$post->id,
            'author' =>  (string)$post->author,
            'title' => (string)$post->title,
            'content' => (string)$post->content,
            'like' => (int)$post->likes,
            'comments' => (array((string)$post->comments)),
        ];
    }
}
