<?php
namespace App\View\Components;

use Illuminate\View\Component;

class Sidebar extends Component
{
    public $guestMessageCount;

    public function __construct($guestMessageCount)
    {
        $this->guestMessageCount = $guestMessageCount;
    }

    public function render()
    {
        return view('components.sidebar');
    }
}
