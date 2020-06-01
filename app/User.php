<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email', 'password', 'role', 'first_name', 'last_name'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get lessons only if it's a professor
     * @return array|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function lessons()
    {
        return $this->role === 'professor' ? $this->hasMany('App\Lesson') : [];
    }

    /**
     * Get sessions only if it's a professor
     * @return array|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function sessions()
    {
        return $this->role === 'professor' ? $this->hasMany('App\Session') : [];
    }

    /**
     * Get student sessions only if it's a student
     * @return array|\Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function studentsessions()
    {
        return $this->role === 'student' ? $this->hasMany('App\StudentSession', 'student_id') : [];
    }

    public function roleToFr()
    {
        switch ($this->role)
        {
            case 'student':
                return 'étudiant';
            case 'professor':
                return 'professeur';
            case 'admin':
                return 'Administrateur';
        }
    }
}
