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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->integer('price')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('available_pieces')->nullable();
            $table->integer('weight')->nullable();
            $table->string('color')->nullable();
            $table->string('col_1')->nullable();
            $table->integer('sold')->nullable();
            $table->float('rate')->nullable();
            $table->string('description',500)->nullable();
            $table->string('col_2')->nullable();
            $table->string('col_3')->nullable();
            $table->string('col_4')->nullable();
            $table->string('about',500)->nullable();
            $table->string('name')->nullable();
            $table->string('brand')->nullable();
            $table->foreignId('store_id')->constrained();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->unsignedBigInteger('added_by')->nullable();
            $table->foreign('added_by')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
