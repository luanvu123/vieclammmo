<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('infos', function (Blueprint $table) {
            $table->id();
            $table->string('email')->nullable();
            $table->string('clock')->nullable();
            $table->text('footer')->nullable();
            $table->string('rss')->nullable();
            $table->string('youtube')->nullable();
            $table->string('facebook')->nullable();
            $table->string('stk')->nullable();
            $table->string('logo_bank')->nullable();
            $table->string('account_name')->nullable();
            $table->text('account_content')->nullable();
            $table->string('qr_code')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('infos');
    }
};
