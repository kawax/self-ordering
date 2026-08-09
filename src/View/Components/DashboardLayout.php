<?php

declare(strict_types=1);

namespace Revolution\Ordering\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class DashboardLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return View
     */
    public function render()
    {
        return view('ordering::layouts.dashboard');
    }
}
