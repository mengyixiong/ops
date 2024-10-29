import { request } from '@/service/request';

/** get user list */
export function fetchGetList(params?: {studlyModule}.{featureName}.SearchParams) {
  return request<{studlyModule}.{featureName}.List>({
    url: '/{module}/{featureName}',
    method: 'get',
    params
  });
}

/** add */
export function fetchAdd(data?: {studlyModule}.{featureName}.Item) {
  return request({
    url: '/{module}/{featureName}',
    method: 'post',
    data
  });
}

/** edit */
export function fetchEdit(id: number, data?: {studlyModule}.{featureName}.Item) {
  return request({
    url: `/{module}/{featureName}/${id}`,
    method: 'put',
    data
  });
}

/** edit */
export function fetchDel(id: number) {
  return request({
    url: `/{module}/{featureName}/${id}`,
    method: 'delete'
  });
}
