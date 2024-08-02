<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCompany extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'company_id', 'is_active', 'created_by', 'updated_by'];

    public function client()
    {
        return $this->belongsTo("App\Models\Client", "client_id");
    }

    public function company()
    {
        return $this->belongsTo("App\Models\Company", "company_id");
    }

}
