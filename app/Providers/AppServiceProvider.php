<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View; // <-- 1. Import View
use App\Models\Menu; // <-- 2. Import Menu Model

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
        // --- 3. เพิ่มส่วนนี้ ---
        // แชร์เมนูทั้งหมด (ที่ active) ไปยังทุก view
        // เราใช้ View Composer เพื่อให้มันทำงานเฉพาะกับ layout ที่เราต้องการ
        View::composer('layouts.public', function ($view) {
            $view->with('public_menus', Menu::orderBy('order', 'asc')->get());
        });
        // --- จบส่วนที่เพิ่ม ---
    }
}