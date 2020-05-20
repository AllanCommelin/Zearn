<?php

use App\Lesson;
use App\Session;
use App\StudentSession;
use App\User;
use Illuminate\Database\Seeder;

class UserLessonSessionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //create student
        $students = factory(User::class, 35)->create(['role' => 'student']);

        //create admin
        factory(User::class)->create(['role' => 'admin']);

        //create lessons with their professor
        $lessons = factory(Lesson::class, 7)->create();

        //create session with lessons
        foreach ($lessons as $lesson){
            $sessions = factory(Session::class, random_int(1, 10))->create(['lesson_id' => $lesson->id]);

            foreach ($sessions as $session){
                foreach ($students as $student){
                    if (mt_rand(1, 3) == 2){
                        factory(StudentSession::class)->create([
                            'session_id' => $session->id,
                            'student_id' => $student->id,
                            'student_mark' => ($session->completed) ? mt_rand(0,20) : null
                        ]);
                    }
                }
            }
        }
    }
}
