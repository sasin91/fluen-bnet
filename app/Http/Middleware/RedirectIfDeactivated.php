<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class RedirectIfDeactivated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $result = User::onlyDeactivated()->get()->filter(function (User $user) use ($request) {
            return $user->email === $request->email;
        });

        if (! $result->isEmpty() )
        {
            alert()->info($message = trans('activation.inactive'), trans('activation.patience'));
            return redirect()->back()->with('status', $message);
        }

        return $next($request);
    }
}
