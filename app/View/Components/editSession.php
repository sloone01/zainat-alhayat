<?php

namespace App\View\Components;

use Illuminate\View\Component;

class editSession extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $sups;
     public $session;
    public function __construct($sups,$session)
    {
        $this->sups = $sups;
        $this->session = $session;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.edit-session');
    }
}
