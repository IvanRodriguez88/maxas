<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_id', 
        'intermediary_id', 
        'company_level_id', 
        'name', 
        'social_object', 
        'is_active', 
        'created_by', 
        'updated_by'
    ];

    public function group()
    {
        return $this->belongsTo("App\Models\Group", "group_id");
    }

    public function intermediary()
    {
        return $this->belongsTo("App\Models\Intermediary", "intermediary_id");
    }

    public function companyLevel()
    {
        return $this->belongsTo("App\Models\CompanyLevel", "company_level_id");
    }

    public function accounts(){
        return $this->belongsToMany('App\Models\Account', 'accounts_companies', 'company_id', 'account_id');
    }


}
