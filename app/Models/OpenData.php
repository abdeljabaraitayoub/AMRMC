<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenData extends Model
{
    use HasFactory;
    public $fillable = ['user_id', 'tables', 'accepted_at'];


    public $casts = [
        'tables' => 'array',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
