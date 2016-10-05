<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class RedirectIfUnconfirmed
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
        $result = User::onlyUnconfirmed()->get()->filter(function (User $user) use ($request) {
            return $user->email === $request->email;
        });

        if (! $result->isEmpty() )
        {
            alert()->info($message = trans('confirmation.unconfirmed'), trans('confirmation.required'));
            return redirect()->back()->with('status', $message);
        }

        return $next($request);
    }
}
