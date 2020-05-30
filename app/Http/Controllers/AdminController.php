<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCreateSession;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Lesson;
use App\Session;
use App\StudentSession;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->paginate(15, '*', 'user_pages');
        $lessons = Lesson::paginate(15, '*', 'lesson_pages');

        return view('dashboard/admin')->with(['users' => $users, 'lessons' => $lessons]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editUser(User $user)
    {
        return view('admin.edit_user')->with(['user' => $user]);
    }

    /**
     * Show the application dashboard.
     *
     * @param UpdateUserRequest $request
     * @param User $user
     * @return void
     */
    public function updateUser(UpdateUserRequest $request, User $user)
    {
        $user->update([
            'first_name' => $request->input('FirstName'),
            'last_name' => $request->input('LastName'),
            'email' => $request->input('Email'),
            'role' => $request->input('Role'),
        ]);
        return redirect()->back()->with('successMsg', 'Utilisateur modifié !');
    }

    /**
     * Show the application dashboard.
     *
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function deleteUser(User $user)
    {
        StudentSession::where('student_id', $user->id)->delete();
        $user->delete();
        return redirect('admin/home')->with('deleteUserSuccess', 'Utilisateur Supprimé !');
    }

    /**
     * Show the application dashboard.
     *
     * @param Lesson $lesson
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function editLesson(Lesson $lesson)
    {
        $professors = User::whereRole('professor')->get();
        $sessions = Session::whereLessonId($lesson->id)->orderBy('completed')->orderBy('start_datetime')->paginate(15);
        return view('admin.edit_lesson')->with([
            'lesson' => $lesson,
            'professors' => $professors,
            'sessions' => $sessions
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @param UpdateLessonRequest $request
     * @param Lesson $lesson
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function updateLesson(UpdateLessonRequest $request, Lesson $lesson)
    {
        $lesson->update([
            'name' => $request->input('Name'),
            'professor_id' => $request->input('Professor'),
        ]);
        return redirect()->back()->with('successMsg', 'Formation modifiée !');
    }

    /**
     * Create Session.
     *
     * @param UpdateLessonRequest $request
     * @param Lesson $lesson
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function createSession(AdminCreateSession $request)
    {
        $nb_hour = Session::calculateNbHour($request->input('start_datetime'), $request->input('end_datetime'));
        $validated = $request->validated();
        $validated['nb_hour'] = $nb_hour;
        Session::create($validated);

        return redirect()->back()->with('successMsg', 'Créneau créé !');
    }
}
