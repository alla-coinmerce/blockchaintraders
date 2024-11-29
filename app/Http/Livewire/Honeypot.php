<?php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Log;
use Livewire\Component;

abstract class Honeypot extends Component
{
    public $allowContactByMobilePhone = "no";
    public $keepInformedAboutUpdates = "yes";

    public function submit()
    {
        $spamScore = 0;

        if('no' !== $this->allowContactByMobilePhone)
        {
            Log::warning('Livewire Honeypot: field allowContactByMobilePhone spoofed');

            $spamScore++;
        }

        if('yes' !== $this->keepInformedAboutUpdates)
        {
            Log::warning('Livewire Honeypot: field keepInformedAboutUpdates spoofed');

            $spamScore++;
        }

        if($spamScore > 1)
        {
            return;
        }

        return $this->processForm();
    }

    abstract protected function processForm();
    abstract public function render();
}
