<?php

namespace App\Http\Controllers;

use App\Lesson;
use App\Session;
use App\StudentSession;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
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

    public function handleMark(Lesson $lesson, StudentSession $studentSession)	
    {
        $markName = 'mark-' . $studentSession->id;
        $newMark = request()->all()[$markName];

        $studentSession->student_mark = $newMark;
        $studentSession->save();

        return redirect()->route('professor.single', [
            'lesson' => $lesson->id
        ]);
    }

    public function handleReport(Lesson $lesson, Session $session)	
    {
        $reportName = 'session-report-' . $session->id;
        $newReport = request()->all()[$reportName];

        $session->report = $newReport;
        $session->save();

        return redirect()->route('professor.single', [
            'lesson' => $lesson->id
        ]);
    }
}