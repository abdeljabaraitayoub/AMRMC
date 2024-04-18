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
        'position',
        'bio',
        'association_id',

    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

    public function association()
    {
        return $this->belongsTo(Association::class, 'association_id');
    }
}
