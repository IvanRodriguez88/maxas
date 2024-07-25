<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitType extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'is_active', 'created_by', 'updated_by'];

}
