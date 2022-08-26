<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function users()
    {
        return view('admin.users', [
            'users' => User::orderBy('id', 'DESC')->get()
        ]);
    }
}
