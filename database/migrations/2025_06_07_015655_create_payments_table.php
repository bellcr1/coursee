<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_id')->unique();  // معرف الدفع من Stripe
            $table->unsignedBigInteger('user_id');   // ربط مع المستخدم (ali)
            $table->integer('amount');                // المبلغ (بـ centimes)
            $table->string('currency', 10);
            $table->string('status');                 // حالة الدفع (succeeded, requires_action,...)
            $table->string('payment_method')->nullable(); // طريقة الدفع (id البطاقة أو غيرها)
            $table->integer('attempt_count')->default(1); // عدد المحاولات (تتبع)
            $table->timestamps();
    
            // مفتاح أجنبي يربط المستخدم (مفروض عندك جدول users)
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
