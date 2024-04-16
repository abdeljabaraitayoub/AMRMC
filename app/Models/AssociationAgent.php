<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationAgent extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        'id',
        'association_id',
        'position',
        'bio'
    ];
}
