<?php

namespace App\Http\Middleware;

use App\Role;
use Closure;
use Illuminate\Support\Facades\Auth;

class AuthCompanyOwner
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
	    if(!Auth::check()) {
		    return redirect("/");
	    }

	    if(Auth::user()->role_id != Role::SUPER_ADMIN && Auth::user()->role_id != Role::COMPANY_OWNER) {
		    return redirect(route("home"))->withErrors("Permission denied");
	    }

	    return $next($request);
    }
}
