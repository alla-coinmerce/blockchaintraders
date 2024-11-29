<?php

namespace App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    public $incrementing = false;

    protected $appends = ['expires_at'];

    public function isExpired()
    {
        return $this->last_activity < Carbon::now()->subMinutes(config('session.lifetime'))->getTimestamp();
    }

    public function getExpiresAtAttribute()
    {
        return Carbon::createFromTimestamp($this->last_activity)->addMinutes(config('session.lifetime'))->toDateTimeString();
    }
}