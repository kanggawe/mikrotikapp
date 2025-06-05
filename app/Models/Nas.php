<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nas extends Model
{
    protected $table = 'nas';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nasname', 'shortname', 'type', 'ports', 'secret', 'server', 'community', 'description'
    ];
}
