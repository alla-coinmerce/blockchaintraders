<?php

namespace App\View\Components\Web;

use Illuminate\View\Component;

class Layout extends Component
{
    /**
     * @var string
     */
    public $current_locale;

    /**
     * @var string
     */
    public $available_locales;

    /**
     * Create a new comp
     * 
     * @return void
     */
    public function __construct()
    {
        $this->current_locale = app()->getLocale();

        $available_locales = config('app.available_locales');

        $this->available_locales = Array();
        foreach($available_locales as $locale_name => $available_locale)
        {
            if('Dutch'  === $locale_name)
            {
                $locale_name = __("Dutch");
            }
            elseif('English'  === $locale_name)
            {
                $locale_name = __("English");
            }

            $this->available_locales[$locale_name] = $available_locale;
        }
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.web.layout');
    }
}
