<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureMessageExists
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
        $messageId = $request->route('messageId');
        $message = \App\Models\Message::find($messageId);
        if (empty($message))
        {
            return response([
                'success' => 'failed',
                'description' => 'No such message',
            ],
                '404');
        }
        return $next($request);
    }
}
