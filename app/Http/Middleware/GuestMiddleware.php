<?php

namespace App\Http\Middleware;

use Auth;
use Closure;

class GuestMiddleware {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		// Test for an even vs. odd remote port
		if (Auth::check()) {
			return $next($request);
		} else {
			return redirect('login');
		}
	}
}
