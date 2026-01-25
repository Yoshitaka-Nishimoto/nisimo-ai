<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $fillable = [
        'name',
        'rank',
        'rubber',
        'style',
        'photo_path',
        'win_rate',
        'last_visit_date',
    ];
}
