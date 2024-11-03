import { request } from '@/service/request';

/** get user list */
export function fetchGetList(params?: Finance.voucher.SearchParams) {
  return request<Finance.voucher.List>({
    url: '/finance/voucher',
    method: 'get',
    params
  });
}

/** add */
export function fetchAdd(data?: Finance.voucher.Item) {
  return request({
    url: '/finance/voucher',
    method: 'post',
    data
  });
}

/** edit */
export function fetchEdit(id: number, data?: Finance.voucher.Item) {
  return request({
    url: `/finance/voucher/${id}`,
    method: 'put',
    data
  });
}

/** edit */
export function fetchDel(id: number) {
  return request({
    url: `/finance/voucher/${id}`,
    method: 'delete'
  });
}
