<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'return_request_invoice_company_id', 'client_payment_proof', 'in_bank',
        'is_active', 'created_by', 'updated_by'
    ];

    public function returnRequestInvoiceCompany()
    {
        return $this->belongsTo("App\Models\ReturnRequestInvoiceCompany", "return_request_invoice_company_id", "id");
    }

}
