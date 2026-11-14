<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->unsignedInteger('price');
            $t->string('unit')->default('/ proyek');
            $t->text('description')->nullable();
            $t->json('features')->nullable();
            $t->string('image')->nullable();
            $t->timestamps();
        });
        Schema::create('articles', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->string('slug')->unique();
            $t->text('body');
            $t->string('image')->nullable();
            $t->timestamps();
        });
        Schema::create('galleries', function (Blueprint $t) {
            $t->id();
            $t->string('title');
            $t->text('description')->nullable();
            $t->string('image')->nullable();
            $t->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('galleries');
        Schema::dropIfExists('articles');
        Schema::dropIfExists('products');
    }
};
