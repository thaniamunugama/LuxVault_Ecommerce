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
            $table->id('product_id');
            $table->unsignedBigInteger('seller_id');
            $table->enum('brand', ['Hermes', 'Chanel', 'Charles and Keith', 'Coach', 'YSL']);
            $table->string('name', 255);
            $table->text('description')->nullable();
            $table->decimal('price', 10, 2);
            $table->integer('quantity');
            $table->string('image', 255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            
            $table->foreign('seller_id')->references('seller_id')->on('sellers')->onDelete('cascade');
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
