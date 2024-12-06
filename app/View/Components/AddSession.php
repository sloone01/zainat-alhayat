<?php

namespace App\View\Components;

use Illuminate\View\Component;

class AddSession extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

     public $sups;
     public $day;
     public $timetable;

     
    public function __construct($day,$sups,$timetable)
    {
        $this->sups = $sups;
        $this->day = $day;
        $this->timetable = $timetable;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.add-session');
    }
}
