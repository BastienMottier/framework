<?php

namespace App\Http\Middleware;

use Nova\Support\Facades\Auth;
use Nova\Support\Facades\Config;
use Nova\Support\Facades\Redirect;

use Closure;


class RedirectIfAuthenticated
{

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $guard = $guard ?: Config::get('auth.defaults.guard', 'web');

        if (Auth::guard($guard)->check()) {
            // Get the Guard's paths from configuration.
            $paths = Config::get("auth.guards.{$guard}.paths", array(
                'dashboard' => 'admin/dashboard'
            ));

            return Redirect::to($paths['dashboard']);
        }

        return $next($request);
    }
}