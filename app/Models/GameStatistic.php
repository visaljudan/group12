<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameStatistic extends Model
{
    use HasFactory;
    protected $fillable = [
        'player_id',
        'wins',
        'losses',
        'ties',
    ];
}
