<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentSessionSubscribeFormRequest;
use App\Lesson;
use App\Session;
use App\StudentSession;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function homeStudent()
    {
        $lessons = Lesson::with('sessions', 'professor')->paginate(15);
        return view('student/lessons')->with('lessons', $lessons);
    }

    public function sessionSubscribe(StudentSessionSubscribeFormRequest $request)
    {
        $session = Session::find($request['session_id']);
        if($session) {
            StudentSession::create([
                'student_id' => Auth::user()->id,
                'session_id' => $session->id,
            ]);
            return redirect()->back();
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function sessionUnsubscribe($id)
    {
        $session = Session::find($id);
        if($session) {
            $studentSession = StudentSession::where([
                ['student_id', Auth::user()->id],
                ['session_id', $session->id],
            ])->delete();
            return redirect()->back();
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function LessonSessions(Lesson $lesson)
    {
        $sessions = Session::with('students')->where('lesson_id', $lesson->id)->orderByDesc('start_datetime')->paginate(15);
        $sessions_subscribe = [];
        foreach (Auth::user()->studentsessions as $studentSession)
        {
            $sessions_subscribe[] = $studentSession->session_id;
        }
        return view('student/lesson_sessions', [
            'lesson' => $lesson,
            'sessions' => $sessions,
            'sessions_sub' => $sessions_subscribe
        ]);
    }

    public function studentSessions()
    {
        $student_sessions = StudentSession::where('student_id', Auth::user()->id)->with('session.lesson.professor')->get();

        return view('student/student_sessions', [
            'student_sessions' => $student_sessions
        ]);
    }
}
