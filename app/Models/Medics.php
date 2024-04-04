<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Medics extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'name',
        'type',
        'dosage_form',
        'manufacturer',
        'price',
        'description',
        'image',
    ];
}
