<?php

use App\Enums\GlobalConstant;

if (!function_exists('buildTree')) {
    function buildTree($items, $parentId = 0): array
    {
        $branch = array();

        foreach ($items as $item) {
            if ($item['pid'] == $parentId) {
                $item['children'] = buildTree($items, $item['id']);
                $branch[]         = $item;
            }
        }

        return $branch;
    }
}


/**
 * 构建前端路由
 */
if (!function_exists('buildFrontRouter')) {
    function buildFrontRouter($menus): array
    {
        $routes = [];
        foreach ($menus as $key => &$menu) {
            $route = [
                'name' => $menu['name'],
                'path' => $menu['path'],
                'meta' => [
                    'hideInMenu' => false,
                    'icon'       => $menu['icon'] ?? '',
                    'title'      => $menu['title'],
                    'order'      => $menu['sort'],
                ]
            ];
            if ($menu['pid'] == 0) {
                $route['component'] = 'layout.base';
                if (empty($menu['children'])) {
                    $route['component'] .= "\${$menu['component']}";
                }
            } else {
                if (empty($menu['children'])) {
                    $route['component'] = $menu['component'];
                }
            }
            if (!empty($menu['children'])) {
                $route['children'] = buildFrontRouter($menu['children']);
            }

            # 是否显示在菜单栏
            $route['meta']['hideInMenu'] = $menu['is_hide_menu'] == GlobalConstant::YES;

            # 语言包名称
            if ($menu['i18n_key']) {
                $route['meta']['i18Key'] = $menu['i18n_key'];
            }

            $routes[] = $route;
        }
        return $routes;
    }
}
