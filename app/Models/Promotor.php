<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotor extends Model
{
    use HasFactory;
    
    protected $fillable = ['name', 'description', 'is_active', 'created_by', 'updated_by'];

    public function clients(){
        return $this->belongsToMany('App\Models\Client', 'promotor_clients', 'promotor_id', 'client_id');
    }

}
