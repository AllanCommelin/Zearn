<?php

namespace App\Http\Controllers;

use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        switch (Auth::user()->role)
        {
            case 'student':
                return redirect()->action('StudentController@homeStudent');
            case 'professor':
                return redirect()->action('ProfessorController@index');
            case 'admin':
                return redirect()->route('home_admin');
        }
    }


}
