<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestInvoiceCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_request_invoice_id', 'company_id', 'account_id', 'intermediary_id',
        'is_active', 'created_by', 'updated_by'
    ];

    public function returnRequestInvoice()
    {
        return $this->belongsTo("App\Models\ReturnRequestInvoice", "return_request_invoice_id", "id");
    }

    public function company()
    {
        return $this->belongsTo("App\Models\Company", "company_id", "id");
    }

    public function account()
    {
        return $this->belongsTo("App\Models\Account", "account_id", "id");
    }
   
    public function intermediary()
    {
        return $this->belongsTo("App\Models\Intermediary", "intermediary_id", "id");
    }

}
