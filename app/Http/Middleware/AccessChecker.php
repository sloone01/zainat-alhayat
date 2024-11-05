<?php

namespace App\Http\Middleware;

use App\Models\Ticket;
use App\Providers\RoleHelper;
use Closure;
use Couchbase\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Mockery\Matcher\HasValue;

class AccessChecker
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next,$role)
    {
        if(!Auth::check())
            return Redirect::route('login');

       $access =  RoleHelper::haveRole(RoleHelper::admin);
        if($access)
            return $next($request);



        return $next($request);


    }
}
