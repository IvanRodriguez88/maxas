<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'company_id', 'account_id', 'promotor_id', 'return_base_id', 'date',
        'invoice', 'total_return', 'comission_charged', 'iva', 'social_cost', 'account_destiny_id',
        'comission_promotor', 'comission_cab', 'comission_play', 'play_return',
        'cab5T', 'return_percentage', 'return_base_id', 'total_invoice', 'client_payment_proof',
        'is_active', 'created_by', 'updated_by'
    ];

    public function client()
    {
        return $this->belongsTo("App\Models\Client", "client_id", "id");
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

    public function status()
    {
        return $this->belongsTo("App\Models\ReturnRequestStatus", "return_request_status_id", "id");
    }

    public function returnTypes()
    {
        return $this->hasMany('App\Models\ReturnRequestReturnType', 'return_request_id', 'id');
    }

}
