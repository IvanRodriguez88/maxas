<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequestReturnType extends Model
{
    use HasFactory;

    protected $fillable = ['return_request_id','beneficiary_name', 'bank_id',
        'return_type_id', 'account_number', 'amount', 'reference', 'dispersion_voucher_file', 'account_id',
        'is_active', 'created_by', 'updated_by'];

    public function bank()
    {
        return $this->belongsTo("App\Models\Bank", "bank_id", "id");
    }

    public function returnType()
    {
        return $this->belongsTo("App\Models\ReturnType", "return_type_id", "id");
    }

	public function account()
    {
        return $this->belongsTo("App\Models\Account", "account_id", "id");
    }
}
