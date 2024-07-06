<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'user_id', 'client_type_id', 'is_active', 'created_by', 'updated_by'];

    public function promotors(){
        return $this->belongsToMany('App\Models\Promotor', 'promotor_clients', 'client_id', 'promotor_id');
    }
}
