<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('category');
            $table->string('name_cotcher');
            $table->text('description');
            $table->decimal('price', 8, 2);
            $table->integer('duration');
            $table->string('image')->nullable();
            $table->string('video')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->timestamps();
    
            $table->foreign('category')->references('id')->on('categories');
            $table->foreign('user_id')->references('id')->on('users');


        });
    }

    public function down()
    {
        Schema::dropIfExists('courses');
    }
};