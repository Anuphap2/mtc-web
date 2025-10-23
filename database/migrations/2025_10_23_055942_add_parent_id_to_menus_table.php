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
        Schema::table('menus', function (Blueprint $table) {
            // เพิ่มคอลัมน์ parent_id หลัง 'order'
            // nullable() คืออนุญาตให้เป็นค่าว่าง (สำหรับเมนูหลัก)
            // constrained() คือเชื่อม Foreign Key ไปที่ 'id' ของตาราง 'menus'
            // onDelete('cascade') คือถ้าลบเมนูแม่ ให้ลบเมนูย่อยตามไปด้วย (เลือกใช้ตามความเหมาะสม)
            $table->foreignId('parent_id')
                ->nullable()
                ->after('order')
                ->constrained('menus') // อ้างอิงกลับไปที่ตาราง menus
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            // ลบ Foreign Key constraint ก่อน
            $table->dropForeign(['parent_id']);
            // แล้วค่อยลบคอลัมน์
            $table->dropColumn('parent_id');
        });
    }
};
