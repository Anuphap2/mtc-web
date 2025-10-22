<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

// (แนะนำ) ให้เปลี่ยนชื่อไฟล์นี้เป็น AdminLayout.php และเปลี่ยนชื่อ class เป็น AdminLayout
// แต่ถ้าง่ายๆ คือแก้ไฟล์นี้เลย
class AppLayout extends Component 
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // แก้ตรงนี้!!
        return view('layouts.admin'); 
    }
}