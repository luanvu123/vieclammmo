<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('name');
            $table->string('avatar')->nullable();
            $table->string('phone')->nullable();
            $table->string('url_facebook')->nullable();
            $table->string('Front_ID_card_image')->nullable();
            $table->string('Back_ID_card_image')->nullable();
            $table->string('Portrait_image')->nullable();
            $table->boolean('isTelegram')->default(false);
            $table->boolean('isApi')->default(false);
            $table->boolean('is2Fa')->default(false);
            $table->string('google2fa_secret')->nullable();
            $table->string('idCustomer')->unique();
            $table->decimal('Balance', 15, 2)->default(0);
            $table->boolean('isOnline')->default(false);
            $table->enum('Status', ['active', 'inactive', 'banned'])->default('active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('customers');
    }
};
