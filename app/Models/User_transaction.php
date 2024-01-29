<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_transaction extends Model
{
    use HasFactory;

    protected $table='user_transactions';
    protected $fillable=[
        'user_id',
        'type',
        'amount',
        'game_type',
        'session_id',
    ];
}
