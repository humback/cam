<?php

namespace App\Http\Middleware;

use App\Services\Wechat\Device\DeviceServiceProvider;
use App\Services\Wechat\OpenAPI\OpenAPIProvider;
use Closure;
use EasyWeChat\Foundation\Application;

class Wechat
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $config = config('wechat');
        $request->wechat = new Application($config);
        return $next($request);
    }
}
