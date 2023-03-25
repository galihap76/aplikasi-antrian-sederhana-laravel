<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
//use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class M_auth extends Authenticatable
{
    use HasFactory;
    protected $table = "tbl_auth";
    

    protected $fillable = [
        'username', 'password'
    ];
}
