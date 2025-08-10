<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $fillable = ['name', 'token'];
    protected $hidden = ['token'];
}
