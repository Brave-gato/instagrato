<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Input extends Component
{
    public $id;
    public $type;
    public $name;
    public $value;

    public function __construct($id = null, $type = null, $name, $value = null)
    {
        $this->id = $id;
        $this->type = $type;
        $this->name = $name;
        $this->value = $value;
    }

    public function render()
    {
        return view('components.input');
    }
}
