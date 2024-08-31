<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'social_cost', 'request_type_id', 'return_base_id',
        'comission_charged',
        'total_return',
        'return_percentage_play', 'return_percentage_promotor', 'return_percentage_intermediary',
        'comission_promotor', 'comission_intermediary', 'comission_play', 'play_return',
        'return_percentage',
        'is_active', 'created_by', 'updated_by'
    ];

    public function returnBase()
    {
        return $this->belongsTo("App\Models\ReturnBase", "return_base_id", "id");
    }

    public function requestType()
    {
        return $this->belongsTo("App\Models\RequestType", "request_type_id", "id");
    }

   
}

