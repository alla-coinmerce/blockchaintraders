<?php

namespace App\Http\Livewire\Portal;

use App\Models\Message;
use Illuminate\Support\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class MessagesList extends Component
{
    use WithPagination;

    public $paginate;

    public $start_date;
    public $end_date;

    public function boot()
    {
        $this->paginate = session()->has('messages_paginate') ? session('messages_paginate') : '20';
        $this->start_date = session()->has('start_date') ? session('start_date') : '';
        $this->end_date = session()->has('end_date') ? session('end_date') : '';
    }

    public function change()
    {
        session(['messages_paginate' => $this->paginate]);
        session(['start_date' => $this->start_date]);
        session(['end_date' => $this->end_date]);
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {
        $messages = Message::orderBy('created_at', 'DESC')
            ->when($this->start_date, function($query) {
                $query->where('created_at', '>=', $this->start_date);
            })
            ->when($this->end_date, function($query) {
                $query->where('created_at', '<=', Carbon::createFromFormat('Y-m-d', $this->end_date)->addDay()); // Add 1 day to account for 24 hours that day
            })
            ->paginate($this->paginate);

        return view('livewire.portal.messages-list', [
            'messages' => $messages
        ]);
    }
}
