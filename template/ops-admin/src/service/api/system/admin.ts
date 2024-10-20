import { request } from '@/service/request';
/** get user list */
export function fetchGetUserList(params?: Api.SystemManage.UserSearchParams) {
  return request<Api.SystemManage.UserList>({
    url: '/system/admin',
    method: 'get',
    params
  });
}
