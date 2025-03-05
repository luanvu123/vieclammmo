<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('uid_facebooks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stock_id')->constrained()->onDelete('cascade'); // Liên kết với stock
            $table->string('uid')->unique(); // UID Facebook
            $table->string('status')->default('active'); // Trạng thái (active/inactive)
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('uid_facebooks');
    }
};
