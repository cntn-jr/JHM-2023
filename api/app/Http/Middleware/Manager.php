<?php

namespace App\Http\Middleware;

use App\Const\Role;
use Closure;
use Exception;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Manager
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 管理者のみアクセス可能
        if ($request->user()->role != Role::MANAGER) {
            throw new Exception('Only manager have access to resources.', 403);
        }

        return $next($request);
    }
}
