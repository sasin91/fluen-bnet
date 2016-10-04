<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @param Request $request
     * @return View|\Illuminate\Http\RedirectResponse
     */
    public function welcome(Request $request)
    {
        $user = $request->user();

        if (empty($user->email) || empty($user->name))
        {
            $transPath = 'home.battleNetUser.finalize';
            alert()->info(trans("$transPath.message"), trans("$transPath.title"));
            return view('home.user.finalize');
        }

        $user->load('characters');
        return view('home.welcome', compact('user'));
    }

    public function api() : View
    {
        return view('home.api.dashboard');
    }
}
