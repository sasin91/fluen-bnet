<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function welcome(Request $request) : View
    {
        $user = $request->user()->with('characters');

        if (empty($user->email) || empty($user->name))
        {
            alert()->info('Just a few things before we get started.', 'Welcome');
            return view('social.user.finish', compact('user'));
        }

        return view('home.welcome', compact('user'));
    }

    public function api() : View
    {
        return view('home.api.dashboard');
    }
}
