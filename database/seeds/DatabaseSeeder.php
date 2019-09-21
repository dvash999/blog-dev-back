<?php

use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;


class DatabaseSeeder extends Seeder
{

    public function run()
    {
//         $this->call(UsersTableSeeder::class);
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        User::truncate();
        Post::truncate();

        $userQuantity = 200;
        $postQuantity = 10;

        factory(User::class, $userQuantity)->create();
        factory(User::class, $postQuantity);
    }
}
