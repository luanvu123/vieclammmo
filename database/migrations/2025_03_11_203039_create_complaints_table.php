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
       Schema::create('complaints', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('customer_id');
    $table->unsignedBigInteger('order_id');
    $table->text('content');
    $table->enum('status', ['pending', 'resolved'])->default('pending');
    $table->timestamps();

    $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
    $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
