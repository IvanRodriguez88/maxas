<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotor extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name', 'comission_ban', 'comission_flu', 'comission_nom',
        'user_id', 'balance',
        'is_active', 'created_by', 'updated_by'];

    public function clients()
    {
        return $this->hasMany('App\Models\Client');
    }

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id");
    }

}
