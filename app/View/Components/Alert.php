<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Illuminate\View\View;

class Alert extends Component
{
    public const DANGER = 'danger';
    public const SUCCESS = 'success';
    public string $type;
    public string $message;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct(
        string $type,
        string $message)
    {
        $this->type = $type;
        $this->message = $message;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View
    {
        return view('components.alert');
    }
}
