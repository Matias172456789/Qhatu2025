<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelQuestion extends Model
{
    protected $table = 'level_question';

    protected $fillable = [
        'id',
        'level_id',
        'question'
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    
    public function options()
    {
        return $this->hasMany(LevelQuestionOption::class);
    }

}
