<?php
namespace App\View\Components;
use Illuminate\View\Component;
use Illuminate\View\View;

class AdminLayout extends Component // <-- เปลี่ยนชื่อ Class ตรงนี้
{
    public function render(): View
    {
        return view('layouts.admin');
    }
}