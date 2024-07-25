<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'client_type_id',
    'comission_ban', 'comission_flu', 'comission_nom', 'promotor_id',
    'comission_ban_promotor', 'comission_flu_promotor', 'comission_nom_promotor',
    'return_base_id',
    'is_active', 'created_by', 'updated_by'];

    public function promotor()
    {
        return $this->belongsTo('App\Models\Promotor', 'promotor_id');
    }

    public function returnBase()
    {
        return $this->belongsTo('App\Models\ReturnBase', 'return_base_id');
    }

    public function companies()
    {
        return $this->belongsToMany('App\Models\Company', 'client_companies', 'client_id', 'company_id');
    }

    public function hasCompany($company_id)
    {
        foreach ($this->companies as $company) {
            if ($company->id == $company_id) {
                return true;
            }
        }
        return false;
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id");
    }

    public function clientBusinesses()
    {
        return $this->hasMany("App\Models\ClientBusiness");
    }
}
