<?php

namespace App\View\Components\Portal;

use Illuminate\View\Component;

class PortfolioLayout extends Component
{
    /**
     * @var string
     */
    public $firstname;

    /**
     * @var string
     */
    public $email;

    /**
     * @var string
     */
    public $environment="Portfolio";

    /**
     * Create a new component instance.
     *
     * @param string $firstname
     * @param string $email
     * @return void
     */
    public function __construct($firstname, $email)
    {
        $this->firstname = $firstname;
        $this->email = $email;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.portal.portfolio-layout');
    }
}
