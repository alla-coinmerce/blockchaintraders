<?php

namespace App\View\Components\Portal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\View\Component;

class Article extends Component
{
    /** @var \App\Models\User */
    public $user;
    public $previousPage;

    public function __construct()
    {
        $this->user = Auth::user();
        
        $this->previousPage = URL::previous('/');
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.portal.article');
    }
}