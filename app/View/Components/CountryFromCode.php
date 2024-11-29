<?php

namespace App\View\Components;

use Illuminate\View\Component;
use Symfony\Component\Intl\Countries;

class CountryFromCode extends Component
{
    /**
     * Country
     * 
     * @var string
     */
    public $country;

    /**
     * Create a new component instance.
     *
     * @param string $alpha2Code
     * @return void
     */
    public function __construct(string $alpha2Code = null)
    {
        if($alpha2Code === null)
        {
            $this->country = '';
        }
        elseif(Countries::exists($alpha2Code))
        {
            $this->country = Countries::getName( $alpha2Code );
        }
        else
        {
            $this->country = $alpha2Code;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return $this->country;
    }
}
