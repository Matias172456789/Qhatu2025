<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelQuestionOption extends Model
{
    protected $table = 'level_question_option';

    protected $fillable = [
        'id',
        'level_id',
        'level_question_id',
        'name',
        'correct'
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }
    
    public function question()
    {
        return $this->belongsTo(LevelQuestion::class);
    }

}
