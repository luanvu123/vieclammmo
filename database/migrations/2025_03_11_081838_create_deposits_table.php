<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->decimal('money', 15, 2);
            $table->enum('type', ['nạp tiền', 'rút tiền','mua hàng','bán hàng']);
            $table->text('content')->nullable();
            $table->enum('status', ['thành công', 'thất bại', 'đang chờ'])->default('thành công');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deposits');
    }
};
