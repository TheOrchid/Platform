<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreatePostTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('type');
            $table->integer('section_id')->nullable();
            $table->jsonb('content');
            $table->string('slug', '255')->unique();
            $table->timestamp('publish');
            $table->timestamps();
            $table->softDeletes();

            /*
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');

            $table->foreign('type_id')
                ->references('id')
                ->on('types')
                ->onDelete('cascade');
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('posts');
    }
}
