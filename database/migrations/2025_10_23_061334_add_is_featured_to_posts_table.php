<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            // เพิ่มคอลัมน์ is_featured หลัง category_id
            // default(false) คือ ปกติไม่ใช่ข่าวเด่น
            $table->boolean('is_featured')->default(false)->after('category_id');
        });
    }

    public function down(): void
    {
        Schema::table('posts', function (Blueprint $table) {
            $table->dropColumn('is_featured');
        });
    }
};
