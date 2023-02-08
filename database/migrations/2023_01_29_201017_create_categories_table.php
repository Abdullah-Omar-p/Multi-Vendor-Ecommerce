<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->integer('Price');
            $table->integer('Discount');
            $table->integer('Available_Cices');
            $table->integer('Weight');
            $table->string('Color');
            $table->string('Col_1');
            $table->string('Col_2');
            $table->string('Col_3');
            $table->string('Col_4');
            $table->integer('About');  
            $table->integer('Name');
            $table->integer('Brand');
            $table->unsignedInteger('Parent_id')->nullable();
            $table->integer('Ordering');
            $table->biginteger('Store_Id');
            
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('categories');
    }
};
