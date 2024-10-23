import { request } from '@/service/request';

/** get user list */
export function fetchGetUserList(params?: Api.SystemManage.UserSearchParams) {
  return request<Api.SystemManage.UserList>({
    url: '/system/admin',
    method: 'get',
    params
  });
}

export function fetchGetAllRoles() {
  return request<Setting.SystemRole.AllRole[]>({
    url: '/system/role/get_all_roles',
    method: 'get'
  });
}


/** add admin */
export function fetchAdd(data?: Setting.SystemAdmin.Form) {
  return request({
    url: '/system/admin',
    method: 'post',
    data
  });
}

/** edit admin */
export function fetchEdit(id: number, data?: Setting.SystemAdmin.Form) {
  return request({
    url: `/system/admin/${id}`,
    method: 'put',
    data
  });
}

/** edit admin */
export function fetchDel(id: number) {
  return request({
    url: `/system/admin/${id}`,
    method: 'delete'
  });
}
