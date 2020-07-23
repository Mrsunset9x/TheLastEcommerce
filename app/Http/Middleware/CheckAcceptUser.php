<?php

namespace App\Http\Middleware;

use Closure;

class CheckAcceptUser
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
        $message = 'Your account is not Accept please wait the admin say Yes :))';
        if(auth()->check() && auth()->user()->status ==0)
        {
            auth()->logout();
            return redirect()->route('home')->with($message);
        }
        return $next($request);
    }
}
