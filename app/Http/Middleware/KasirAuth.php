<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class KasirAuth
{
  public function handle($request, Closure $next)
  {
    if (Auth::guard('kasir')->check()) {
      return $next($request);
    }
    return redirect('/');
  }
}
