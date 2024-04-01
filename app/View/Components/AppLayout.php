<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class AppLayout extends Component
{
    public string $class;
    public bool $wFull;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', bool $wFull = false)
    {
        $this->class = $class;
        $this->wFull = $wFull;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return View
     */
    public function render(): View
    {
        return view('layouts.app');
    }
}
