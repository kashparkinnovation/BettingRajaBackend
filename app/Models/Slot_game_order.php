<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slot_game_order extends Model
{
    use HasFactory;

    protected $table='slot_game_orders';
    protected $fillable=[
        'user_id',
        'status',
        'amount',
        'final_amount',
        'playing_datetime',
    ]; 
}
