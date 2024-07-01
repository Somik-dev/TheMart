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
        Schema::create('stripe_oders', function (Blueprint $table) {
            $table->id();
            $table->integer('customer_id');
            $table->string('fname');
            $table->string('lname')->nullable();
            $table->integer('country');
            $table->integer('city');
            $table->integer('Zip');
            $table->string('company')->nullable();
            $table->string('email');
            $table->string('phone');
            $table->string('address');
            $table->string('massage')->nullable();
            $table->integer('ship_check')->nullable();
            $table->string('ship_fname')->nullable();
            $table->string('ship_lname')->nullable();
            $table->integer('ship_country')->nullable();
            $table->integer('ship_city')->nullable();
            $table->integer('ship_zip')->nullable();
            $table->string('ship_company')->nullable();
            $table->string('ship_email')->nullable();
            $table->string('ship_phone')->nullable();
            $table->string('ship_adress')->nullable();
            $table->integer('charge')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('sub_total')->nullable();
            $table->integer('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stripe_oders');
    }
};
