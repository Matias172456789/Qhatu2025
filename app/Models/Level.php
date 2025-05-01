<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $table = 'level';

    protected $fillable = [
        'id',
        'name',
        'description',
        'link',
        'minim_calification'
    ];

    public function questions()
    {
        return $this->hasMany(LevelQuestion::class);
    }
}
