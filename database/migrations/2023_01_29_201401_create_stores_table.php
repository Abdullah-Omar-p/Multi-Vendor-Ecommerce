<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->foreignId('user_id')->constrained();
            $table->string('Name');
            $table->string('Phone');                                      // .. Done ..
            $table->string('About');
            $table->string('Website');
            $table->string('services');
            $table->string('Location');
            $table->string('Email');

            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('stores');
    }
};
