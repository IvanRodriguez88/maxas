<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CfdiUse extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'physical_person', 'moral_person', 'is_active', 'created_by', 'updated_by'];

}
