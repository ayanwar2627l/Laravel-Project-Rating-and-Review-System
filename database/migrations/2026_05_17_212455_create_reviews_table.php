<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
    Schema::create('reviews', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->foreignId('product_id')->constrained()->onDelete('cascade');
        $table->tinyInteger('rating')->unsigned()->comment('1 to 5');
        $table->string('title')->nullable();
        $table->text('comment');
        $table->string('image')->nullable();
        $table->boolean('is_verified')->default(false);
        $table->boolean('is_approved')->default(true);
        $table->timestamps();

        // One review per user per product
        $table->unique(['user_id', 'product_id']);
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
