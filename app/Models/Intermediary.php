<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Intermediary extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'comission_percentage', 'user_id', 'is_active', 'created_by', 'updated_by'];

    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id");
    }

}
