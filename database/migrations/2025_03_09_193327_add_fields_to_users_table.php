<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('image')->nullable()->after('email');
            $table->string('linkedin_url')->nullable()->after('image');
            $table->string('twitter_url')->nullable()->after('linkedin_url');
            $table->string('category')->nullable()->after('twitter_url');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['image', 'linkedin_url', 'twitter_url', 'category']);
        });
    }
};