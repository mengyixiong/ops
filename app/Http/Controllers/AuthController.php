<?php

namespace App\Http\Controllers;

use App\Enums\GlobalConstant;
use App\Exceptions\ApiException;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\SystemAdmin;
use App\Models\SystemCompany;
use App\Models\SystemMenu;
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

        # 超级管理员不用关联公司和角色
        if ($admin->is_super_admin == GlobalConstant::NO) {
            # 判断是否关联公司
            if ($admin->companies->isEmpty()) {
                throw new ApiException('用户未关联公司');
            }

            # 判断是否关联角色
            if ($admin->roles->isEmpty()) {
                throw new ApiException('用户未关联角色');
            }
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

        # 获取主体
        if ($request->user()->is_super_admin == GlobalConstant::YES) {
            $companies = SystemCompany::query()->get();
        } else {
            # 非超级管理员，获取当前用户的公司
            $companies = $request->user()->companies;
        }

        $admin = $request->user()
            ->leftJoin('system_companies as b', 'system_admins.current_com_id', '=', 'b.id')
            ->select(['system_admins.*', 'b.name as current_com_name', 'b.abb as current_com_abb'])
            ->where('system_admins.id', $request->user()->id)
            ->first();

        # 获取当前登录主体名称
        return $this->succData([
            'info'        => $admin,
            'permissions' => $permissions,
            'companies'   => $companies,
        ]);
    }

    /**
     * 获取用户的菜单路由
     */
    public function getUserRoutes(Request $request)
    {
        # 判断是否是超级管理员
        if ($request->user()->is_super_admin == GlobalConstant::YES) {
            # 超级管理员的菜单
            $menus = SystemMenu::query()
                ->where(function (Builder $query) {
                    $query->whereJsonLength('com_id', 0)
                        ->orWhereJsonContains('com_id', request()->user()->current_com_id);
                })
                ->where('type', SystemMenu::TYPE_MENU)
                ->get();
        } else {
            # 获取角色和权限
            $menus = $request->user()->roles()
                ->with(['menus' => function ($query) {
                    $query->whereJsonLength('com_id', 0)->orWhereJsonContains('com_id', request()->user()->current_com_id);
                }])
                ->get()->pluck('menus')->flatten()->unique('id');

            # 查询父级菜单
            $menusToAdd = collect();
            foreach ($menus as $menu) {
                $menusToAdd->push($menu);

                # 将此菜单的所有父级菜单添加到集合中
                $parent = $menu->parent;
                while ($parent !== null) {
                    $menusToAdd->push($parent);
                    $parent = $parent->parent;
                }
            }

            # 菜单去重
            $menus = $menusToAdd->unique('id')->sortBy('id');
        }

        # 构建菜单树
        if ($menus) {
            $menus = buildTree($menus->toArray());
            $menus = buildFrontRouter($menus);
        }
        return $this->succData([
            'home'   => 'home',
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

        return $this->succOk();
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
