<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Label extends Component
{
    public $for;
    public $class;

    public function __construct($for, $class = null)
    {
        $this->for = $for;
        $this->class = $class;
    }

    public function render()
    {
        return view('components.label');
    }
}
