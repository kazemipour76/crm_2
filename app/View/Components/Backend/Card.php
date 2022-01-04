<?php

namespace App\View\Components\Backend;

use Illuminate\View\Component;

class Card extends Component
{
    public $color;

    public $title;
    public $isCollapse;
    public $noPadding;
    public $icon;

//    public $title;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($title, $color = 0, $isCollapse = false, $noPadding = false, $icon = null)
    {
        $this->title = $title;
        $this->color = $color;
        $this->noPadding = $noPadding;
        $this->icon = $icon;
        $this->isCollapse = $isCollapse;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.backend.card');
    }


}
