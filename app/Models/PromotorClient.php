<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PromotorClient extends Model
{
    use HasFactory;
    
    protected $fillable = ['promotor_id', 'client_id', 'commission', 'is_active', 'created_by', 'updated_by'];

    public function promotor()
    {
        return $this->belongsTo("App\Models\Promotor", "promotor_id", "id");
    }

    public function client()
    {
        return $this->belongsTo("App\Models\Client", "client_id", "id");
    }

}
