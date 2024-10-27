<?php

use App\Enums\GlobalConstant;
use App\Exceptions\ApiException;

if (!function_exists('buildTree')) {
    function buildTree($items, $parentId = 0): array
    {
        $branch = array();

        foreach ($items as $item) {
            if ($item['pid'] == $parentId) {
                $children = buildTree($items, $item['id']);
                if (!empty($children)) {
                    $item['children'] = $children;
                }
                $branch[] = $item;
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

if (!function_exists('getUri')) {
    function getUri($url): string
    {
        if (!$url) {
            throw new ApiException('url不存在');
        }
        return parse_url($url, PHP_URL_PATH);
    }
}

if (!function_exists('extractTheIDsOfTheSubordinates')){
    function extractTheIDsOfTheSubordinates($node)
    {
        $ids = [];
        foreach ($node ->children as $child){
            $ids[] = $child ->id;
            if ($child ->children){
                $ids = array_merge($ids,extractTheIDsOfTheSubordinates($child));
            }
        }
return $ids;
    }
}

/**
 * 排除没有全部选中下级的菜单
 */
if (!function_exists('extractTheSubmenuIDOfTheMenuIds')){
    function extractTheSubmenuIDOfTheMenuIds($menus,$checked)
    {
        foreach ($menus as $menu){
            // 提取所有下级菜单的ID
            $childrenIds = extractTheIDsOfTheSubordinates($menu);
            if (!empty($childrenIds)){
                // 判断$childrenIds是否全部在$checked里面
                if (count(array_diff($childrenIds, $checked)) > 0){
                    $checked = array_filter($checked, function ($value) use ($menu){
                        return $menu->id != $value;
                    });
                }
            }
        }
        return array_map(function ($value){
            return (int)$value;
        }
        ,$checked);
    }
}

/**
 * 判断目录是否为空
 */
if (!function_exists('isDirEmpty')){
    function isDirEmpty($dir): bool
    {
        if (!is_readable($dir)) return false; // 判断目录是否可读
        $files = scandir($dir);
        return count($files) === 2; // 仅包含 '.' 和 '..' 表示空
    }
}


