<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestInvoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_request_id', 'requires_invoice', 'client_business_id', 'promotor_id', 'account_destiny_id',
        'payment_method_id', 'payment_way_id', 'cfdi_use_id', 'origin_account', 'subtotal', 'iva', 'total_invoice', 'return_base_id',
        'is_active', 'created_by', 'updated_by'
    ];

    public function returnRequest()
    {
        return $this->belongsTo("App\Models\ReturnRequest", "return_request_id", "id");
    }

    public function clientBusiness()
    {
        return $this->belongsTo("App\Models\ClientBusiness", "client_business_id", "id");
    }

    public function accounts()
    {
        return $this->hasMany('App\Models\ReturnRequestInvoiceCompany', 'account_id', 'id');
    }

    public function companies()
    {
        return $this->hasMany('App\Models\ReturnRequestInvoiceCompany', 'company_id', 'id');
    }

   
    public function accountDestiny()
    {
        return $this->belongsTo("App\Models\Account", "account_destiny_id", "id");
    }
    
    public function promotor()
    {
        return $this->belongsTo("App\Models\Promotor", "promotor_id", "id");
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
        return $this->hasMany('App\Models\ReturnRequestReturnType', 'return_request_invoice_id', 'id');
    }

    public function returnConcepts()
    {
        return $this->hasMany('App\Models\ReturnRequestConcept', 'return_request_invoice_id', 'id');
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


    protected $appends = ['total_sum_return_type', 'total_returned'];

}
