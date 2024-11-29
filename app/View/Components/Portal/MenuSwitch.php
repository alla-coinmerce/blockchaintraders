<?php

namespace App\View\Components\Portal;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class MenuSwitch extends Component
{
    public $showSwitch;
    public $environment;

    /**
     * Create a new component instance.
     */
    public function __construct($environment = 'Kennisbank')
    {
        $this->environment = $environment;

        /** @var \App\Models\User */
        $user = Auth::user();

        if((
            $user->isParticipant() &&
            $user->isKnowledgeBaseSubscriber()
            )
            ||
            $user->isAdmin()
        )
        {
            $this->showSwitch = true;
        }
        else
        {
            $this->showSwitch = false;
        }
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.portal.menu-switch', [
            'showSwitch' => $this->showSwitch
        ]);
    }
}
