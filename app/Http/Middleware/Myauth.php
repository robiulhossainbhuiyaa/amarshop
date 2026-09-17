<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;

class Myauth
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        /*
        |--------------------------------------------------------------------------
        | Login Session Check
        |--------------------------------------------------------------------------
        */

        if (!session('logged_in')) {

            return redirect()
                ->route('login_user')
                ->with(
                    'msg',
                    'Please login first.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Get Logged In User
        |--------------------------------------------------------------------------
        */

        $userId = session('user_id');

        $user = User::find($userId);


        /*
        |--------------------------------------------------------------------------
        | User Not Found
        |--------------------------------------------------------------------------
        */

        if (!$user) {

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login_user')
                ->with(
                    'msg',
                    'Your account could not be found. Please login again.'
                );
        }


        /*
        |--------------------------------------------------------------------------
        | User Blocked / Inactive
        |--------------------------------------------------------------------------
        */

        if ((int) $user->status === 0) {

            $request->session()->invalidate();
            $request->session()->regenerateToken();
            $session    =   session();
 
            return redirect()
            ->route('login_user')
            ->with( 'msg', 'Your account has been blocked. Please contact support.' );
        }


        /*
        |--------------------------------------------------------------------------
        | User Active
        |--------------------------------------------------------------------------
        */

        return $next($request);
    }
}