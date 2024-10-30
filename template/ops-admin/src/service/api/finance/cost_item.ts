import { request } from '@/service/request';

/** get user list */
export function fetchGetList(params?: Finance.costItem.SearchParams) {
  return request<Finance.costItem.List>({
    url: '/finance/costItem',
    method: 'get',
    params
  });
}

/** add */
export function fetchAdd(data?: Finance.costItem.Item) {
  return request({
    url: '/finance/costItem',
    method: 'post',
    data
  });
}

/** edit */
export function fetchEdit(id: number, data?: Finance.costItem.Item) {
  return request({
    url: `/finance/costItem/${id}`,
    method: 'put',
    data
  });
}

/** edit */
export function fetchDel(id: number) {
  return request({
    url: `/finance/costItem/${id}`,
    method: 'delete'
  });
}
