<?php

namespace App\Enums;

enum KnowledgeBaseAssetType: int
{
    case DOWNLOAD = 1;
    case IMAGE = 2;
    case VIDEO = 3;

    public function label(): string
    {
        return match($this) {
            static::DOWNLOAD => 'download',
            static::IMAGE => 'image',
            static::VIDEO => 'video',
        };
    }
}
