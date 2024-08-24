<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientBusiness extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'file', 'business_name', 'rfc', 'street', 'external_number', 'internal_number', 'cologne', 'state', 'city', 'postal_code', 'is_active', 'created_by', 'updated_by'];

    public function client()
    {
        return $this->belongsTo("App\Models\Client", "client_id");
    }
}
