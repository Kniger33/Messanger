<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureChatExists
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
        $chatId = $request->route('chatId');
        $chat = \App\Models\Chat::find($chatId);
        if (empty($chat))
        {
            return response([
                'success' => 'failed',
                'description' => 'No such chat',
            ],
                '404');
        }
        return $next($request);
    }
}
