<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class AnnualFinancialOverview extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'year',
        'original_file_name',
        'storage_path',

        'created_by',
        'updated_by'
    ];

    protected static function booted () {
        parent::booted();
        
        static::deleting(function(AnnualFinancialOverview $annualFinancialOverview) { 
            Storage::delete($annualFinancialOverview->storage_path);
        });
    }
}
