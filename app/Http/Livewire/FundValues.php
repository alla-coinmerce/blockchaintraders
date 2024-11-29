<?php

namespace App\Http\Livewire;

use App\Contracts\FundSnapshotExportService;
use App\Models\Fund;
use App\Models\FundValue;
use Livewire\Component;
use Livewire\WithPagination;

class FundValues extends Component
{
    use WithPagination;

    public $paginate;

    public $start_date;
    public $end_date;

    /**
     * @var Fund
     */
    public $fund;

    public function boot()
    {
        $this->paginate = session()->has('fundvalue_paginate') ? session('fundvalue_paginate') : '10';
        $this->start_date = session()->has('start_date') ? session('start_date') : '';
        $this->end_date = session()->has('end_date') ? session('end_date') : '';//now()->format('Y-m-d');
    }

    public function change()
    {
        session(['fundvalue_paginate' => $this->paginate]);
        session(['start_date' => $this->start_date]);
        session(['end_date' => $this->end_date]);
    }

    public function updated()
    {
        $this->resetPage();
    }

    public function export(FundSnapshotExportService $fundSnapshotExportService)
    {
        return $fundSnapshotExportService->exportSnapshotsForFund($this->fund, $this->start_date, $this->end_date);
    }

    public function render()
    {
        // dd($this->start_date, $this->end_date);
        $fundValues = FundValue::orderBy('date_time', 'DESC')
            ->where('fund_id', $this->fund->id)
            ->when($this->start_date, function($query) {
                $query->where('date', '>=', $this->start_date);
            })
            ->when($this->end_date, function($query) {
                $query->where('date', '<=', $this->end_date);
            })
            ->paginate($this->paginate);

        return view('livewire.fund-values', ['fundValues' => $fundValues]);
    }
}
