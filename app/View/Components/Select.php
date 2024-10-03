<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Select extends Component
{
    public $name;
    public $label;
    public $model;
    public $options; // You might want to pass options for the select dropdown

    public function __construct($name, $label, $model, $options = [])
    {
        $this->name = $name;
        $this->label = $label;
        $this->model = $model;
        $this->options = $options;
    }

    public function render()
    {
        return view('components.select');
    }
}
