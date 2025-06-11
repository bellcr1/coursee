<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddCompleteAndVerifyToCourseUserTable extends Migration
{
    public function up()
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->boolean('complete')->default(false);
            $table->text('verify')->nullable();
        });
    }

    public function down()
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropColumn('complete');
            $table->dropColumn('verify');
        });
    }
}
