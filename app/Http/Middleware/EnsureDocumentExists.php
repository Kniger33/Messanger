<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureDocumentExists
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
        $documentId = $request->route('documentId');
        $document = \App\Models\Document::find($documentId);
        if (empty($document))
        {
            return response([
                'success' => 'failed',
                'description' => 'No such document',
            ],
                '404');
        }
        return $next($request);
    }
}
