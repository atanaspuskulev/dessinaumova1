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
        Schema::create('paintings', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable(false)->index();
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
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paintings');
    }
};
