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
        Schema::table('categories', function (Blueprint $table) {
            $table->text('description')->after('slug')->nullable();
            $table->mediumText('meta_description')->after('is_active')->nullable();
            $table->string('meta_title')->after('meta_description')->nullable();
            $table->tinyText('meta_keywords')->after('meta_title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropColumn('description');
            $table->dropColumn('meta_description');
            $table->dropColumn('meta_title');
            $table->dropColumn('meta_keywords');
        });
    }
};
