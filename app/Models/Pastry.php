<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pastry extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'pastry_id',
        'type',
        'name',
        'ppu',
        'image'
    ];

    public function batters()
    {
        return $this->hasMany(Batter::class,'pastry_id');
    }

    public function toppings()
    {
        return $this->hasMany(Topping::class,'pastry_id');
    }
}
