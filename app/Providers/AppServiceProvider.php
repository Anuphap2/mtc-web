<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // Import View
use App\Models\Menu; // Import Menu Model

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('layouts.public', function ($view) {
            // --- แก้ไข Logic ตรงนี้ ---
            
            // 1. ดึงเฉพาะเมนูหลัก (parent_id เป็น NULL)
            // 2. ใช้ with('children') เพื่อดึงเมนูย่อยมาพร้อมกัน (Eager Loading)
            // 3. เรียงตาม 'order'
            $public_menus = Menu::whereNull('parent_id')
                                ->with('children') // <-- ดึงเมนูย่อยมาด้วย
                                ->orderBy('order', 'asc')
                                ->get();
            
            $view->with('public_menus', $public_menus);

            // --- จบส่วนแก้ไข ---
        });
    }
}
