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
        // แก้จาก 'layouts.app' เป็น 'layouts.admin'
        return view('layouts.admin');
    }
}