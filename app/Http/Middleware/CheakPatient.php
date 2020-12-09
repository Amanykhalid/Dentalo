<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheakPatient
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $userType=session()->get('user')['userType'];

        if($userType == 'Patient'){
            return $next($request);
        }
        return redirect()->back();
    }
}
