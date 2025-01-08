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
        Schema::create('offers', function (Blueprint $table) {
            $table->id();
            $table->integer('price')->nullable();
            $table->string('name')->nullable();
            $table->string('about')->nullable();
            $table->tinyInteger('custom')->nullable();// this to know if offer for public = 0 or for customers = 1
            $table->enum('status',['active','inactive'])->nullable();
            $table->tinyInteger('no_pieces')->nullable(); // that used when offer contains just one product but many pieces , then this be the number of pieces
            $table->foreignId('store_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offers');
    }
};
