<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class UserDocument extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'display_name',
        'original_file_name',
        'storage_path',
    ];

    protected static function booted () {
        parent::booted();
        
        static::deleting(function(UserDocument $userDocument) { 
            Storage::delete($userDocument->storage_path);
        });
    }
}
