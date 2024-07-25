<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestConcept extends Model
{
    use HasFactory;

    protected $fillable = ['return_request_id', 'amount', 'unit_type_id', 'concept', 'description', 'unit_price', 'total', 'is_active', 'created_by', 'updated_by'];
    
    public function unitType()
    {
        return $this->belongsTo("App\Models\UnitType", "unit_type_id", "id");
    }

}
