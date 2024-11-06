<?php

namespace App\View\Components;

use Illuminate\View\Component;

class PerformanceDialog extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */

    public $cri_id;
    public $class_id;
    public $end_date;
    public $student_id;
    public $cri_type;
    public $value;
    public $name;

    public function __construct($name,$cid,$sid,$cype,$value,$end_date=null,$class_id=1)
    {
        $this->cri_id = $cid;
        $this->$end_date = $end_date;
        $this->class_id = $class_id;
        $this->student_id = $sid;
        $this->cri_type = $cype;
        $this->value = $value;
        $this->name = $name;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.performance-dialog');
    }
}
