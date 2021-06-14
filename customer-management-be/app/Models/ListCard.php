<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListCard extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable =
    [
        'id',
        'name',
        'board_id',
        'is_disabled'
    ];
}
