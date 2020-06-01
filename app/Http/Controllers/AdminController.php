<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminCreateSession;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateLessonRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Lesson;
use App\Session;
use App\User;
use Exception;
use Illuminate\Contracts\Support\Renderable;
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
        $this->middleware(['auth','auth.admin']);
    }

    /**
     * Show Admin's application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $users = User::where('id', '!=', Auth::user()->id)->paginate(15, '*', 'user_pages');
        $lessons = Lesson::paginate(15, '*', 'lesson_pages');

        return view('dashboard/admin')->with(['users' => $users, 'lessons' => $lessons]);
    }

    /**
     * Create a User.
     *
     * @return Renderable
     */
    public function createUser()
    {
        return view('admin.create_user');
    }

    /**
     * Store a User.
     *
     * @param StoreUserRequest $request
     * @return Renderable
     */
    public function storeUser(StoreUserRequest $request)
    {
        $attributes = $request->validated();
        $attributes['password'] = bcrypt('password');
        User::create($attributes);
        return redirect()->route('home_admin');
    }

    /**
     * Edit a User.
     *
     * @return Renderable
     */
    public function editUser(User $user)
    {
        return view('admin.edit_user')->with(['user' => $user]);
    }

    /**
     * Update a User.
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
     * Delete a User.
     *
     * @param User $user
     * @return void
     * @throws Exception
     */
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect('admin/home')->with('successMsg', 'Utilisateur Supprimé !');
    }

    /**
     * Create a Lesson.
     *
     * @return Renderable
     */
    public function createLesson()
    {
        return view('admin.create_lesson')->with(['professors' => User::whereRole('professor')->get()]);
    }

    /**
     * Store a Lesson.
     *
     * @param StoreLessonRequest $request
     * @return Renderable
     */
    public function storeLesson(StoreLessonRequest $request)
    {
        Lesson::create($request->validated());
        return redirect()->route('home_admin');
    }


    /**
     * Edit a Lesson.
     *
     * @param Lesson $lesson
     * @return Renderable
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
     * Update a Lesson.
     *
     * @param UpdateLessonRequest $request
     * @param Lesson $lesson
     * @return Renderable
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
     * @param AdminCreateSession $request
     * @return Renderable
     */
    public function createSession(AdminCreateSession $request)
    {
        $nb_hour = Session::calculateNbHour($request->input('start_datetime'), $request->input('end_datetime'));
        $validated = $request->validated();
        $validated['nb_hour'] = $nb_hour;
        Session::create($validated);

        return redirect()->back()->with('successMsg', 'Créneau créé !');
    }

    /**
     * Delete Lesson.
     *
     * @param Lesson $lesson
     * @return void
     * @throws Exception
     */
    public function deleteLesson(Lesson $lesson)
    {
        $lesson->delete();
        return redirect('admin/home')->with('successMsg', 'Formation supprimée !');
    }
}
