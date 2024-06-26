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
            $table->foreignId("userId")->constrained("users")->onDelete('cascade');;
            $table->foreignId("productId")->constrained("products")->onDelete('cascade');
            $table->integer("rate");
            $table->longText("advantages")->nullable();
            $table->longText("disadvantages")->nullable();
            $table->longText("comment")->nullable();
            $table->timestamps();
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
