<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('is_read')->default(false)->after('message'); // Thêm cột is_read với giá trị mặc định là false
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropColumn('is_read'); // Xóa cột nếu rollback
        });
    }
};
