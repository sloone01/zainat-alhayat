<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Reading extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $sups;
    public $student_id;

    public function __construct($sid,$sups)
    {
        $this->sups = $sups;
        $this->student_id = $sid;
    
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.reading');
    }
}
