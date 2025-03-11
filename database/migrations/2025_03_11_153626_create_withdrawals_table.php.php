<?php

// database/migrations/2025_xx_xx_create_withdrawals_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('withdrawals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained()->onDelete('cascade');
            $table->string('bank');
            $table->string('bankAccName');
            $table->string('bankAccNum');
            $table->decimal('amount', 15, 2);
            $table->enum('status', ['đang chờ', 'thành công', 'thất bại'])->default('đang chờ');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('withdrawals');
    }
};
