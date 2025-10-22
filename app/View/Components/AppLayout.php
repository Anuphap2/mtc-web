<?php
namespace App\View\Components;
use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     */
    public function render(): View
    {
        // แก้ไขบรรทัดนี้ครับ!
        return view('layouts.admin');
    }
}