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
        Schema::create('sellers', function (Blueprint $table) {
            $table->id('seller_id');
            $table->string('fname', 100);
            $table->string('lname', 100);
            $table->string('email', 150)->unique();
            $table->string('phone', 20)->nullable();
            $table->string('password', 255);
            $table->boolean('is_admin')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sellers');
    }
};
