<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('commentable', function (Blueprint $table) {
            $table->id();
            $table->string('Body');
            $table->unsignedInteger('Parent_id')->nullable();
            $table->foreignId('category_id')->constrained();
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    
    public function down()
    {
        Schema::dropIfExists('comments');
    }
};
