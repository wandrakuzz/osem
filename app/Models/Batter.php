<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batter extends Model
{
    use HasFactory;

    protected $fillable = [

        'id',
        'pastry_id',
        'batter_id',
        'type'
    ];

    public function pastry()
    {
        return $this->belongsTo(Pastry::class);
    }
}
