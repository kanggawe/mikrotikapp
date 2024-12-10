<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    // Nama tabel di database
    protected $table = 'customers';

    // Kolom yang bisa diisi melalui Mass Assignment
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'status',
        'registration_date',
        'billing_type',
    ];

    // Tipe kolom untuk casting
    protected $casts = [
        'registration_date' => 'date',
        'status' => 'string',
        'billing_type' => 'string',
    ];
}
