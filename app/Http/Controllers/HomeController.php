<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function showDashboard()
    {
        /** @var App\User $user */
        Auth::login(User::find(2));
        return view('app.dashboard');
    }
}
