<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;

class SessionController extends Controller
{
    public function login(): Application|Factory|View
    {
        return view('auth.login');
    }

    public function register(): View|Factory|Application
    {
        return view('auth.register');
    }
}
