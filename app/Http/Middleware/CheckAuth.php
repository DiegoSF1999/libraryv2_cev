<?php

namespace App\Http\Middleware;

use Closure;
use \Firebase\JWT\JWT;
Use App\users;

class CheckAuth
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
        $users = new Users();

        $user = $users->getuserbyEmail($request->email);
        
        $checking_token = $request->token;

        $real_token = $users->getTokenbyuser($user);

        if($real_token == $checking_token){
            
           
             return $next($request);

        } else {
            return 403;
        }
        
        
    }
}
