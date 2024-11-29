<?php

namespace App\Enums;

enum Role: int
{
    case PARTICPANT = 10;
    case SUBSCRIBER = 11;
    case BOTH = 12;
    case ADMIN = 20;

    public function label(): string
    {
        return match($this) {
            static::PARTICPANT => 'Participant',
            static::SUBSCRIBER => 'Subscriber',
            static::BOTH => 'Participant and subscriber',
            static::ADMIN => 'Administrator',
        };
    }
}
