<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'pastry_id',
        'topping_id',
        'type'
    ];

    public function pastry()
    {
        return $this->belongsTo(Pastry::class);
    }
}
