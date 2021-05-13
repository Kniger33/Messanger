<?php

namespace App\Http\Middleware;

use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class EnsureUserIsAdmin
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
        $userRole = Role::find(User::find($userId)->id_role)->name;
        if ($userRole != 'admin')
        {
            return response([
                'success' => 'failed',
                'description' => 'Allowed only for admin'
            ],
                '403');
        }
        return $next($request);
    }
}
