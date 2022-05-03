<?php

//fixme?

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Cookie;

class SetSessionLength
{
    const SESSION_LIFETIME_PARAM = 'sessionLifetime';
    public $SESSION_LIFETIME_DEFAULT_MINS = 0;

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next) {
        $lifetimeMins = Cookie::get(self::SESSION_LIFETIME_PARAM, $request->input(self::SESSION_LIFETIME_PARAM));
        if ($lifetimeMins) {
            Cookie::queue(self::SESSION_LIFETIME_PARAM, $lifetimeMins, $lifetimeMins);
            config(['session.lifetime' => $lifetimeMins]);
        }
        return $next($request);
    }

    public function getTime() {
        return $this->SESSION_LIFETIME_DEFAULT_MINS;
    }

    public function setTime($min) {
        $this->SESSION_LIFETIME_DEFAULT_MINS = $min;
    }
}
