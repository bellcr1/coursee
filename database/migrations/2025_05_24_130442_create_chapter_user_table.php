<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChapterUserTable extends Migration
{
    public function up()
    {
        Schema::create('chapter_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('chapter_id')->constrained()->onDelete('cascade');
            $table->boolean('quiz_passed')->nullable(); // true, false, or null
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('chapter_user');
    }
}