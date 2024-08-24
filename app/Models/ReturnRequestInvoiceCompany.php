<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestInvoiceCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'date', 'return_base_id', 'request_type_id', 
        'total_return', 'comission_charged', 'social_cost',
        'return_request_status_id', 'total_return',
        'return_percentage_play', 'return_percentage_promotor', 'return_percentage_intermediary',
        'comission_promotor', 'comission_intermediary', 'comission_play', 'play_return',
        'return_percentage', 'return_base_id',
        'is_active', 'created_by', 'updated_by'
    ];

    public function clientBusiness()
    {
        return $this->belongsTo("App\Models\ClientBusiness", "client_business_id", "id");
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

    public function intermediary()
    {
        return $this->belongsTo("App\Models\Intermediary", "intermediary_id", "id");
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

    public function paymentMethod()
    {
        return $this->belongsTo("App\Models\PaymentMethod", "payment_method_id", "id");
    }

    public function paymentWay()
    {
        return $this->belongsTo("App\Models\PaymentWay", "payment_way_id", "id");
    }

    public function cfdiUse()
    {
        return $this->belongsTo("App\Models\CfdiUse", "cfdi_use_id", "id");
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

    public function getTotalReturnedAttribute()
    {
        return $this->returnTypes()->whereNotNull("dispersion_voucher_file")->sum("amount");
    }

    public function getEmptyDispersionVoucherFiles()
    {
        return $this->returnTypes()->whereNull("dispersion_voucher_file")->count();
    }

    public function getStatusBadge()
    {
        switch ($this->return_request_status_id) {
            case 1:
                $color = "danger";
                break;
            case 3:
                $color = "primary";
                break;
            case 4:
                $color = "info";
                break;
            case 5:
                $color = "dark";
                break;
            case 6:
                $color = "success";
                break;
            default:
                $color = "secondary";
                break;
        }
        return '<span class="badge badge-'.$color.' mb-2 me-4">'.$this->status->name.'</span>';
    }

    protected $appends = ['total_sum_return_type', 'total_returned'];

}
