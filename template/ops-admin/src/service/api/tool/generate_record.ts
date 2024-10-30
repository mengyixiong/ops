import { request } from '@/service/request';

/** get user list */
export function fetchGetList(params?: Tool.generateRecord.SearchParams) {
  return request<Tool.generateRecord.List>({
    url: '/tool/generateRecord',
    method: 'get',
    params
  });
}

/** add */
export function fetchAdd(data?: Tool.generateRecord.Item) {
  return request({
    url: '/tool/generateRecord',
    method: 'post',
    data
  });
}

/** edit */
export function fetchEdit(id: number, data?: Tool.generateRecord.Item) {
  return request({
    url: `/tool/generateRecord/${id}`,
    method: 'put',
    data
  });
}

/** edit */
export function fetchDel(id: number) {
  return request({
    url: `/tool/generateRecord/${id}`,
    method: 'delete'
  });
}
