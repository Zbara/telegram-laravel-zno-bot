<?php

namespace App\Http\Controllers;

use App\Models\TelegramUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        return view('home');
    }

    public function stats()
    {
        return view('stats.index', [
            'users' => TelegramUsers::count(),
            'usersDay' => TelegramUsers::where('created_at','>',Carbon::today())->count(),
            'usersStudent' => TelegramUsers::where('role', 1)->count(),
            'usersDayStudent' => TelegramUsers::where('created_at','>',Carbon::today())->where('role', 1)->count(),
            'usersTeacher' => TelegramUsers::where('role', 2)->count(),
            'usersDayTeacher' => TelegramUsers::where('created_at','>',Carbon::today())->where('role', 2)->count(),
        ]);
    }
}
