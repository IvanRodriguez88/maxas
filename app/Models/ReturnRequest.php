<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_business_id', 'company_id', 'account_id', 'promotor_id', 'return_base_id', 'request_type_id', 'date', 'requires_invoice',
        'invoice', 'total_return', 'comission_charged', 'subtotal', 'iva', 'social_cost', 'account_destiny_id',
        'return_percentage_play', 'return_percentage_promotor', 'return_percentage_caballero', 'comission_promotor', 'comission_cab', 'comission_play', 'play_return',
        'return_percentage', 'return_base_id', 'total_invoice', 'client_payment_proof',
        'payment_method_id', 'payment_way_id', 'cfdi_use_id', 'origin_account',
        'is_active', 'created_by', 'updated_by'
    ];

    public function clientBusiness()
    {
        return $this->belongsTo("App\Models\clientBusiness", "client_business_id", "id");
    }

    public function company()
    {
        return $this->belongsTo("App\Models\Company", "company_id", "id");
    }

    public function account()
    {
        return $this->belongsTo("App\Models\Account", "account_id", "id");
    }

    public function accountDestiny()
    {
        return $this->belongsTo("App\Models\Account", "account_destiny_id", "id");
    }
    
    public function promotor()
    {
        return $this->belongsTo("App\Models\Promotor", "promotor_id", "id");
    }

    public function returnBase()
    {
        return $this->belongsTo("App\Models\ReturnBase", "return_base_id", "id");
    }

    public function requestType()
    {
        return $this->belongsTo("App\Models\RequestType", "request_type_id", "id");
    }

    public function status()
    {
        return $this->belongsTo("App\Models\ReturnRequestStatus", "return_request_status_id", "id");
    }

    public function returnTypes()
    {
        return $this->hasMany('App\Models\ReturnRequestReturnType', 'return_request_id', 'id');
    }

    public function returnConcepts()
    {
        return $this->hasMany('App\Models\ReturnRequestConcept', 'return_request_id', 'id');
    }

    public function getTotalSumReturnTypeAttribute()
    {
        return $this->returnTypes()->sum('amount');
    }

    protected $appends = ['total_sum_return_type'];

}
