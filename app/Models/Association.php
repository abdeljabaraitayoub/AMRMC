<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Association extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'city',
        'country',
        'website',
        'description',
        'objectives',
        'activities',
        'image'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime'
    ];

    public function agents()
    {
        return $this->hasMany(AssociationAgent::class);
    }
    public function patients()
    {
        return $this->hasMany(Patient::class);
    }
}
