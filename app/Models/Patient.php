<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'medical_record_number',
        'medical_history',
        'association_id',
        'disease_id',
    ];
    public $timestamps = false;
}
