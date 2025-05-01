<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonLevelQuestionOption extends Model
{
    protected $table = 'person_level_question_option';

    protected $fillable = [
        'id',
        'person_id',
        'level_id',
        'level_question_id',
        'level_question_option_id'
    ];
}
