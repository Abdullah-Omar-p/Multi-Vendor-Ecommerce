<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->integer('Price')->nullable();
            $table->integer('discount')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('shippingcompany')->nullable()->constrained('shipping_companies')->onDelete('set null');
            $table->foreignId('category_id')->constrained();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
