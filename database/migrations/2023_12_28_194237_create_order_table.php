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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_id')->nullable(false)->index();
            $table->bigInteger('amount')->nullable(false);
            $table->char('currency', 3)->nullable(false);
            $table->string('payer_name')->nullable(false);
            $table->string('payer_email')->nullable(false);
            $table->string('payer_phone')->nullable(false);
            $table->string('payer_country')->nullable(false);
            $table->char('payer_country_code', 3)->nullable(false);
            $table->string('payer_state')->nullable(false);
            $table->string('payer_city')->nullable(false);
            $table->string('payer_address')->nullable(false);
            $table->text('additional_information')->nullable();
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('resended_at')->nullable();
            $table->timestamps();
        });
    }
};
