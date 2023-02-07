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
            $table->bigIncrements('ShippingCompany')->unsigned(); //changed this line
            $table->foreign('ShippingCompany')
                ->references('id')
                ->on('ShippinCompanies')
                ->onDelete('cascade');

            $table->foreignId('category_id')->constrained();
            $table->string('location')->nullable();
            //you must makke a trans date coulumn
            //how will make a trans date ??
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
