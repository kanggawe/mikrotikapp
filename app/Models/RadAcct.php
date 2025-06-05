<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RadAcct extends Model
{
    protected $table = 'radacct';
    protected $primaryKey = 'radacctid';
    
    protected $fillable = [
        'username',
        'nasipaddress',
        'acctsessionid',
        'acctuniqueid',
        'framedipaddress',
        'acctsessiontime',
        'acctauthentic',
        'acctstarttime',
        'acctstoptime',
        'callingstationid',
        'calledstationid',
        'nasporttype',
        'nasportid'
    ];

    protected $casts = [
        'acctstarttime' => 'datetime',
        'acctstoptime' => 'datetime',
    ];

    /**
     * Get the NAS device for this accounting record.
     */
    public function nas()
    {
        return $this->belongsTo(Nas::class, 'nasipaddress', 'nasname');
    }
}