<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{   
    // This middleware will check if the authenicated user is an admin
    // so that he should have permission to certain requests
    
    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if(Auth::check()){
            if($user['type'] == 'admin'){
                return $next($request);
            } else {
                session()->flash('error', 'You are not an Admin !!!');
                return redirect('/home');
            }
        }
        session()->flash('error', 'Please, Log In !!!');
        return redirect('/');
    }
}
