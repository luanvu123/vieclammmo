<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sender_id'); // Người gửi
            $table->unsignedBigInteger('receiver_id'); // Người nhận
            $table->text('message')->nullable(); // Nội dung tin nhắn
            $table->string('attachment')->nullable(); // Đường dẫn file đính kèm
            $table->enum('status', ['sent', 'delivered', 'read'])->default('sent'); // Trạng thái tin nhắn
            $table->timestamps();

            // Thiết lập khóa ngoại
            $table->foreign('sender_id')->references('id')->on('customers')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('customers')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('messages');
    }
};
