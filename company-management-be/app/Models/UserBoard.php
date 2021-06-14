<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBoard extends Model
{
    protected $fillable =
    [
        'id',
        'user_id',
        'board_id',
    ];
}
