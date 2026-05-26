<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('moments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('date');
            $table->text('body');
            $table->string('category')->default('personal'); // personal | professional | milestone
            $table->boolean('published')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('moments');
    }
};
