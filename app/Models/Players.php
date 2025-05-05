<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Players extends Model
{
    use HasFactory;
    protected $table = 'players';
    protected $fillable = [
        'player_name',
        'credit_points',
        'series_id',
        'team_id',
        'position_id',
        'status',
        'image',
        'image_name',
    ];
}
