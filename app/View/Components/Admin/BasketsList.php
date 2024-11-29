<?php

namespace App\View\Components\Admin;

use App\Models\Fund;
use Illuminate\View\Component;

class BasketsList extends Component
{
    /**
     * @var Fund[]
     */
    public $funds;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->funds = Fund::all();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.baskets-list');
    }
}
