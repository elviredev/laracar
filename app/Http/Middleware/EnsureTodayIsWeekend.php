<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureTodayIsWeekend
{
    /**
     * Handle an incoming request.
     * Autoriser l'accès à la route uniquement si on est le week-end
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
      $dayOfWekk = now()->dayOfWeek;

      if ($dayOfWekk === 6 || $dayOfWekk === 0) {
        return $next($request);
      }
      abort(403, 'The website can only be accessed on weekends');
    }
}
