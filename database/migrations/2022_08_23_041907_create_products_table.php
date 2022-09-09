<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->text('product_description');
            $table->string('product_image');
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete();
            $table->foreignId('store_id')->constrained('stores')->cascadeOnDelete();
            $table->enum('status', ['published', 'unpublished', 'scheduled'])->default('published');
            $table->string('slug')->unique();
            $table->float('base_price');
            $table->integer('sku')->nullable();
            $table->string('Quantity')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
};
