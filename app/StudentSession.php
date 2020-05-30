<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class StudentSession extends Model
{
    protected $table = 'studentsessions';

    protected $fillable = [
        'id',
        'student_id',
        'session_id',
        'student_mark',
    ];

    /**
     * Get User student
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function student()
    {
        return $this->belongsTo('App\User', 'student_id');
    }

    /**
     * Get session
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function session()
    {
        return $this->belongsTo('App\Session');
    }
}
