import { request } from '@/service/request';
/** get company list */
export function fetchGetList(params?: Setting.SystemMenu.SearchParams) {
  return request<Setting.SystemMenu.Menu[]>({
    url: '/system/menu',
    method: 'get',
    params
  });
}

/** add company */
export function fetchAdd(data?: Setting.SystemMenu.Form) {
  return request({
    url: '/system/menu',
    method: 'post',
    data
  });
}

/** edit company */
export function fetchEdit(id: number, data?: Setting.SystemMenu.Form) {
  return request({
    url: `/system/menu/${id}`,
    method: 'put',
    data
  });
}

/** edit company */
export function fetchDel(id: number) {
  return request({
    url: `/system/menu/${id}`,
    method: 'delete'
  });
}

/**
 * 获取所有的菜单
 */
export function fetchGetAllMenus(id: number) {
  return request<Setting.SystemMenu.MenuTree[]>({
    url: '/system/menu/get_all_menus',
    method: 'get',
    params: {
      id
    }
  });
}

/**
 * 获取所有的菜单和权限
 */
export function fetchGetAllMenusAndPermissions() {
  return request<Setting.SystemMenu.MenuTree[]>({
    url: '/system/menu/get_menus_and_permissions',
    method: 'get'
  });
}
