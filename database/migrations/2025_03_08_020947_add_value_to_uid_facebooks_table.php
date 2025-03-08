<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('uid_facebooks', function (Blueprint $table) {
            $table->string('value')->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('uid_facebooks', function (Blueprint $table) {
            $table->dropColumn('value');
        });
    }
};
