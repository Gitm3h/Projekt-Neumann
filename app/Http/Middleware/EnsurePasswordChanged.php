<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsurePasswordChanged
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $onPasswordPage = $request->routeIs('password.force','password.force.update', 'logout');

    if ($user && $user->must_change_password && ! $onPasswordPage) {
        return redirect()->route('password.force');
    }
        return $next($request);
    }
}
