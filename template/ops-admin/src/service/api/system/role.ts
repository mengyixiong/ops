import { request } from '@/service/request';
/** get company list */
export function fetchGetList(params?: Setting.SystemRole.SearchParams) {
  return request<Api.Common.List>({
    url: '/system/role',
    method: 'get',
    params
  });
}

/** add company */
export function fetchAdd(data?: Setting.SystemRole.Form) {
  return request({
    url: '/system/role',
    method: 'post',
    data
  });
}

/** edit company */
export function fetchEdit(id: number, data?: Setting.SystemRole.Form) {
  return request({
    url: `/system/role/${id}`,
    method: 'put',
    data
  });
}

/** edit company */
export function fetchDel(id: number) {
  return request({
    url: `/system/role/${id}`,
    method: 'delete'
  });
}
