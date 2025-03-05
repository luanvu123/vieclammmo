<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->integer('quantity_success')->nullable()->after('status');
            $table->integer('quantity_error')->nullable()->after('quantity_success');
        });
    }

    public function down()
    {
        Schema::table('stocks', function (Blueprint $table) {
            $table->dropColumn(['quantity_success', 'quantity_error']);
        });
    }
};
