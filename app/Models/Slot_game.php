<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot_game extends Model
{
    use HasFactory;

    protected $table='slot_games';
    protected $fillable=[
        'single_number_chance',
        'double_number_chance',
        'jackpot_number_chance',
        'loosing_number_chance',
    ];
}
