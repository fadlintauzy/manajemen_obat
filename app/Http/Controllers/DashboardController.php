<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $username = session('logged_username', Auth::user()?->username);

        return view('dashboard.index', compact('username'));
    }
}
