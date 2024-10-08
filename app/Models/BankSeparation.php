<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankSeparation extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'is_active', 'created_by', 'updated_by'];

}
