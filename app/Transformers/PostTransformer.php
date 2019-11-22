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
    public function transform(Post $post)
    {
        return [
            'id' => (int)$post->id,
            'title' => (string)$post->title,
//            'email' => (string)$user->email,
//            'isVerified' => (int)$user->verified,
//            'isAdmin' => ($user->admin === 'true'),
//            'creationDate' => $user->created_at,
//            'lastChanged' => $user->updated_at,
//            'deletedDate' => isset($user->deleted_at) ? (string)$user->deleted_at : null,

            'links' => [
                'rel' => 'self',
//                'href' => route('users.show', $user->id)
            ]
        ];
    }
}
