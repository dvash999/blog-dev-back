<?php

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;


class DatabaseSeeder extends Seeder
{

    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Post::truncate();

        User::flushEventListeners();
        Post::flushEventListeners();

        $userQuantity = 200;
        $postQuantity = 10;

        factory(User::class, $userQuantity)->create();
        factory(User::class, $postQuantity);
    }
}
