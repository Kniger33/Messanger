<?php

namespace App\Http\Middleware;

use Closure;
use http\Client\Curl\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;


class EnsureUserExists
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
        $userId = $request->route('userId');
        $user = \App\Models\User::find($userId);
        if (empty($user))
        {
            return response([
                'success' => 'failed',
                'description' => 'No such user',
            ],
                '404');
        }
        return $next($request);
    }
}
