<?php

namespace App\View\Components\Admin;

use App\Models\Message;
use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * @var bool
     */
    public $unreadMessages;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->unreadMessages = Message::where('read', false)->count();
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.admin.layout');
    }
}
