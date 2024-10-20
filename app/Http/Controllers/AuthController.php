<?php

namespace App\Http\Controllers;

use App\Enums\GlobalConstant;
use App\Exceptions\ApiException;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SystemAdmin;
use App\Models\SystemMenu;
use App\Models\SystemRole;
use Illuminate\Database\Eloquent\Builder;
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
            'token'        => $token->plainTextToken,
            'refreshToken' => $token->plainTextToken,
            'expire'       => $expire->timestamp,
        ]);
    }

    /**
     * 刷新token
     */
    public function refresh(Request $request)
    {
        return $this->succData($this->changeTheToken());
    }

    public function logout(Request $request)
    {
        # 撤销用于验证当前请求的令牌...
        $request->user()->currentAccessToken()->delete();

        return $this->succOk();
    }

    /**
     * 获取用户信息和菜单权限信息
     */
    public function me(Request $request)
    {
        # 获取权限
        $permissions = $request->user()->roles()->with('permissions')->get()->pluck('permissions')->flatten();
        if ($request->user()->is_super_admin == GlobalConstant::YES) {
            # 超级管理员的和权限
            $permissions = SystemMenu::query()
                ->whereNot('type', SystemMenu::TYPE_MENU)
                ->get();
        }

        # 提取权限码
        if ($permissions) {
            $permissions = $permissions->pluck('permission')->toArray();
        }

        return $this->succData([
            'info'        => $request->user(),
            'permissions' => $permissions
        ]);
    }

    /**
     * 获取用户的菜单路由
     */
    public function getUserRoutes(Request $request)
    {
        # 获取角色和权限
        $menus = $request->user()->roles()->with('menus')->get()->pluck('menus')->flatten()->unique('id');
        if ($request->user()->is_super_admin == GlobalConstant::YES) {
            # 超级管理员的菜单和权限
            $menus = SystemMenu::query()
                ->whereIn('com_id', [0, $request->user()->current_com_id])
                ->where('type', SystemMenu::TYPE_MENU)
                ->get();
        }

        # 构建菜单树
        if ($menus) {
            $menus = buildTree($menus->toArray());
            $menus = buildFrontRouter($menus);
        }
        return $this->succData([
            'home'        => 'home',
            'routes' => $menus
        ]);
    }

    public function isRouteExist()
    {
        return $this->succData(true);
    }

    /**
     * 切换主体
     */
    public function changeCompany(Request $request)
    {
        # 切换主体
        $request->user()->current_com_id = $request->com_id;
        $res                             = $request->user()->save();
        if (!$res) {
            throw new ApiException('切换主体失败');
        }

        return $this->succData(
            $this->changeTheToken()
        );
    }

    /**
     * 更换token
     */

    public function changeTheToken()
    {
        $request = request();

        # 撤销用于验证当前请求的令牌...
        $request->user()->currentAccessToken()->delete();

        # 生成Token
        $expire = now()->addMinutes(config('sanctum.expiration'));
        $token  = $request->user()->createToken('api-auth', ["*"], $expire);

        return [
            'token'  => $token->plainTextToken,
            'expire' => $expire->timestamp,
        ];
    }
}
