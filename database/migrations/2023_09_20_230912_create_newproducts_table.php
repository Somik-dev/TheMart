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
        Schema::create('newproducts', function (Blueprint $table) {
            $table->id();
            $table->integer('status')->nullable();
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('brand_id')->nullable();
            $table->string('product_name');
            $table->integer('price');
            $table->integer('discount')->nullable();
            $table->integer('after_discount');
            $table->string('tags');
            $table->longText('short_desp')->nullable();
            $table->longText('long_desp');
            $table->longText('addi_info')->nullable();
            $table->string('preview');
            $table->string('slug');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newproducts');
    }
};
