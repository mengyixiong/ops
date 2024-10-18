<?php

namespace App\Http\Controllers;

use App\Exceptions\ApiException;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SystemAdmin;
use Illuminate\Http\Request;

class AuthController extends BaseController
{
    /**
     * 登录
     */
    public function login(LoginRequest $request)
    {
        $admin = SystemAdmin::where('username', $request->username)->first();
        if (empty($admin)) {
            throw new ApiException('用户名或密码错误');
        }

        # 比对密码
        if (!password_verify($request->password, $admin->password)) {
            throw new ApiException('用户名或密码错误');
        }

        # 更新最后登录时间和 IP
        $admin->last_login_ip = $request->ip();
        $admin->last_login_at = now();
        $admin->save();

        # 生成Token
        $expire = now()->addMinutes(config('sanctum.expiration'));
        $token  = $admin->createToken('api-auth', ["*"], $expire);

        return $this->succData([
            'token'  => $token->plainTextToken,
            'expire' => $expire->timestamp,
        ]);
    }

    /**
     * 刷新token
     */
    public function refresh(Request $request)
    {
        # 撤销用于验证当前请求的令牌...
        $request->user()->currentAccessToken()->delete();

        # 刷新token
        $expire = now()->addMinutes(config('sanctum.expiration'));
        $token  = $request->user()->createToken('api-auth', ["*"], $expire);

        return $this->succData([
            'token'  => $token->plainTextToken,
            'expire' => $expire->timestamp,
        ]);
    }

    public function logout(Request $request)
    {
        # 撤销用于验证当前请求的令牌...
        $request->user()->currentAccessToken()->delete();

        return $this->succOk();
    }

    public function me(Request $request){
        return $this->succData($request->user());
    }
}
