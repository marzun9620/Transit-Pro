<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            if($request->routeIs('admin.*')){
                return route('admin.login');
            }
            if($request->routeIs('buses.reserve')){
                return route('admin.login');
            }
            if($request->routeIs('buses.*')){
                return route('admin.login');
            }
            if($request->routeIs('products.*')){
                return route('admin.login');
            }
            if($request->routeIs('doctor.*')){
                return route('doctor.login');
            }
            if($request->routeIs('staff.*')){
                return route('staff.login');
            }
            return route('user.login');
        }
    }
}
