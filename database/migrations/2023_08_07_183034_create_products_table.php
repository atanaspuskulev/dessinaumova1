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
            $table->string('title')->unique();
            $table->string('slug')->unique();
            $table->string('short_description')->nullable()->index();
            $table->text('description')->nullable(false)->fulltext();
            $table->string('material')->nullable()->index();
            $table->string('dimentions1')->nullable(false);
            $table->string('dimentions2')->nullable();
            $table->string('dimentions3')->nullable();
            $table->bigInteger('price')->nullable()->index();
            $table->char('currency',3)->nullable()->index();
            $table->text('delivery')->nullable();
            $table->boolean('sold')->default(false)->index();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->timestamps();
            $table->softDeletes();
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
