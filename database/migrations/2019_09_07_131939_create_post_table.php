<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostTable extends Migration
{
    public function up()
    {
        Schema::create('post', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('author');
            $table->string('title');
            $table->string('content');
            $table->date('date');
            $table->timestamps();
        });
    }
    public function down()
    {
        Schema::dropIfExists('post');
    }
}
