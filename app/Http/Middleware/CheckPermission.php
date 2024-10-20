<?php

namespace App\Http\Middleware;

use App\Enums\GlobalConstant;
use App\Exceptions\ApiException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        # 超级管理员直接放行
        if ($request->user()->is_super_admin == GlobalConstant::YES) {
            return $next($request);
        }

        # 用户所有权限
        $permissions = $request->user()->roles()->with('permissions')->get()->pluck('permissions')->flatten()->pluck('permission');

        # 验证权限
        if (!$permissions->contains($request->route()->getName())) {
            throw new ApiException('没有权限', 403);
        }

        return $next($request);
    }
}
