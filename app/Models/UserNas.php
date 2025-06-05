<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNas extends Model
{
    protected $table = 'user_nas';
    public $timestamps = false;
    protected $fillable = ['username', 'nas_id'];
}
