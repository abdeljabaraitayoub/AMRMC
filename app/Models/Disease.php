<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Disease extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'symptoms',
        'causes',
        'treatment',
    ];

    public function patients()
    {
        return $this->hasMany(Patient::class, 'disease_id');
    }
}
