<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AppLayout extends Component
{
    public string $class;
    public string $extendedClass;
    public bool $isHeaderWidthFull;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($class = '', $extendedClass = '', $isHeaderWidthFull = false)
    {
        $this->class = $class;
        $this->extendedClass = $extendedClass;
        $this->isHeaderWidthFull = $isHeaderWidthFull;
    }

    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
