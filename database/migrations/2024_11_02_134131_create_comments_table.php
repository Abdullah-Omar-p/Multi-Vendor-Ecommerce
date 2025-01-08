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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('body', 500);
            $table->enum('type', [1/*question*/, 2/*rate*/,3 /*reply to question*/])->nullable();
            $table->unsignedInteger('parent_id')->nullable();
            $table->foreignId('product_id')->constrained()->nullable()->onDelete('cascade');
            $table->float('rate')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
