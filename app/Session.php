<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $table = 'sessions';

    protected $fillable = [
        'id',
        'lesson_id',
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

    /**
     * Get lesson of session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function lesson()
    {
        return $this->belongsTo('App\Lesson', 'lesson_id');
    }

    public static function calculateNbHour($start_datetime, $end_datetime)
    {
        $start_hour = \DateTime::createFromFormat('Y-m-d\TG:i', $start_datetime);
        $end_hour = \DateTime::createFromFormat('Y-m-d\TG:i', $end_datetime);

        return date_diff($start_hour, $end_hour)->format('%H:%I');
    }
}
