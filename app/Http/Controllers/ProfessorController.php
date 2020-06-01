<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Session;
use App\StudentSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfessorController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.professor');
    }

    public function index()
    {
        return view('lesson.index', [
            'lessons' => Lesson::where('professor_id', Auth::user()->id)->paginate(15),
        ]);
    }

    public function single(Lesson $lesson)
    {
        $sessions = $lesson->sessions;
        $pastSessions = [];
        $incomingSessions = [];
        $now = new \Datetime('now');
        $now = $now->format('Y-m-d G:i:s');

        foreach ($sessions as $session) {
            if ($session->start_datetime < $now) {
                $pastSessions[] = $session;
            }
            elseif ($session->start_datetime >= $now) {
                $incomingSessions[] = $session;
            }
        }

        return view('lesson.single', [
            'lesson' => $lesson,
            'past_sessions' => $pastSessions,
            'incoming_sessions' => $incomingSessions,
        ]);
    }

    public function handleMark($lesson, $studentSessionParam)
    {
        $studentSession = StudentSession::find($studentSessionParam);
        $markName = 'mark-' . $studentSession->id;
        $newMark = request()->all()[$markName];

        $studentSession->student_mark = $newMark;
        $studentSession->save();

        $studentMark = $studentSession->student_mark < 10 ? '0' . $studentSession->student_mark .'/20' : $studentSession->student_mark . '/20';

        return new Response($studentMark, '200');
    }

    public function handleReport($lesson, $sessionParam)
    {
        $session = Session::find($sessionParam);

        $reportName = 'session-report-' . $session->id;
        $newReport = request()->all()[$reportName];

        $session->report = $newReport;
        $session->save();

        return new Response($session->report, '200');
    }
}
