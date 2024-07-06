<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = ['bank_id', 'currency_type_id', 'account_number', 'balance', 'clabe', 'ava', 'swift', 'is_active', 'created_by', 'updated_by'];

    public function bank()
    {
        return $this->belongsTo("App\Models\Bank", "bank_id");
    }

    public function currencyType()
    {
        return $this->belongsTo("App\Models\CurrencyType", "currency_type_id");
    }

    public function accounts(){
        return $this->belongsToMany('App\Models\Company', 'accounts_companies', 'account_id', 'company_id');
    }



}
