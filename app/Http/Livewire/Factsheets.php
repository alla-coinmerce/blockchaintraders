<?php

namespace App\Http\Livewire;

use App\Models\Factsheet;
use Livewire\Component;
use Livewire\WithPagination;

class Factsheets extends Component
{
    use WithPagination;

    public $paginate;

    public $start_year;
    public $start_week;
    public $end_year;
    public $end_week;

    /**
     * @var Fund
     */
    public $fund;

    public function boot()
    {
        $this->paginate = session()->has('fundvalue_paginate') ? session('fundvalue_paginate') : '10';
        $this->start_year = session()->has('start_year') ? session('start_year') : '';
        $this->start_week = session()->has('start_week') ? session('start_week') : '';
        $this->end_year = session()->has('end_year') ? session('end_year') : '';
        $this->end_week = session()->has('end_week') ? session('end_week') : '';
    }

    public function change()
    {
        session(['fundvalue_paginate' => $this->paginate]);
        session(['start_year' => $this->start_year]);
        session(['start_week' => $this->start_week]);
        session(['end_year' => $this->end_year]);
        session(['end_week' => $this->end_week]);
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function render()
    {
        $factsheets = Factsheet::orderBy('year', 'DESC')
            ->orderBy('week', 'DESC')
            ->where('fund_id', $this->fund->id)
            ->when($this->start_year, function($query) {
                $query->where('year', '>=', $this->start_year);
            })
            ->when($this->start_week, function($query) {
                $query->where('week', '>=', $this->start_week);
            })
            ->when($this->end_year, function($query) {
                $query->where('year', '<=', $this->end_year);
            })
            ->when($this->end_week, function($query) {
                $query->where('week', '<=', $this->end_week);
            })
            ->paginate($this->paginate);

        return view('livewire.factsheets', ['factsheets' => $factsheets]);
    }
}
