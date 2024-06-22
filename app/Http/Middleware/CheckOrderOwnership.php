<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckOrderOwnership
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $order = $request->route('order');
        if ($request->user()->cannot('update', $order)) {
            return forbiddenResponse('Unauthorized');
        }

        return $next($request);
    }
}
