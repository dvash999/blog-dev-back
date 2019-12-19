<?php

namespace App\Transformers;

use App\Models\User;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'id' => (int)$user->id,
            'name' => (string)$user->name,
            'email' => (string)$user->email,
            'isVerified' => (int)$user->verified,
            'isAdmin' => ($user->admin === 'true'),
            'creationDate' => $user->created_at,
            'lastChanged' => $user->updated_at,
            'deletedDate' => isset($user->deleted_at) ? (string)$user->deleted_at : null,

            'links' => [
                'rel' => 'self',
                'href' => route('users.show', $user->id)
            ]
        ];
    }
}
