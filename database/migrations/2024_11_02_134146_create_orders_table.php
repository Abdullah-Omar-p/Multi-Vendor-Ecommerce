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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('price')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->tinyInteger('status')->nullable();
//            $table->foreignId('product_id')->constrained()->nullable();
            $table->foreignId('store_id')->nullable()->constrained()->onDelete('cascade');

            $table->foreignId('offer_id')->nullable()->constrained()->onDelete('cascade');
//            $table->foreignId('offer_id')->constrained()->nullable();
            $table->string('location')->nullable();
            $table->timestamp('trans_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
