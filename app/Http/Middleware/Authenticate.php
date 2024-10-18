<?php

namespace App\Http\Middleware;

use App\Exceptions\ApiException;
use App\Traits\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    use Response;
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }

    public function unauthenticated($request, array $guards)
    {
        if ($request->is('api/*')) {
            throw new ApiException('未登录', 401);
        }
        parent::unauthenticated($request, $guards);
    }
}
