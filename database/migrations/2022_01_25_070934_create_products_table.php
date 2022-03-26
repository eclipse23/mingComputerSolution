<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
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
            $table->unsignedBigInteger('category_id');
            $table->string('name')->nullable();
            $table->string('brand')->nullable();
            $table->longText('description')->nullable();
            $table->longText('specification')->nullable();
            $table->integer('discount')->nullable();
            $table->decimal('price');
            $table->boolean('hot_deal')->default(false);
            $table->boolean('new_arrival')->default(false);
            $table->integer('stock');
            $table->integer('sold')->nullable();
            $table->integer('reserved')->nullable();
            $table->timestamps();

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
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
}
