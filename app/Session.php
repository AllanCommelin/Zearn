<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    protected $fillable = [
        'id',
        'lesson_id',
        'professor_id',
        'report',
        'nb_hour',
        'nb_classroom',
        'start_datetime',
        'end_datetime',
        'completed',
    ];

    /**
     * Get students of session
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function students()
    {
        return $this->hasMany('App\StudentSession');
    }

    /**
     * Get professor of session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function professor()
    {
        return $this->belongsTo('App\User', 'professor_id');
    }
}
