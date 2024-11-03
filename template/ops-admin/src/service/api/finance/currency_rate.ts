import { request } from '@/service/request';

/** get user list */
export function fetchGetList(params?: Finance.currencyRate.SearchParams) {
  return request<Finance.currencyRate.List>({
    url: '/finance/currencyRate',
    method: 'get',
    params
  });
}

/** add */
export function fetchAdd(data?: Finance.currencyRate.Item) {
  return request({
    url: '/finance/currencyRate',
    method: 'post',
    data
  });
}

/** edit */
export function fetchEdit(id: number, data?: Finance.currencyRate.Item) {
  return request({
    url: `/finance/currencyRate/${id}`,
    method: 'put',
    data
  });
}

/** edit */
export function fetchDel(id: number) {
  return request({
    url: `/finance/currencyRate/${id}`,
    method: 'delete'
  });
}

/** edit */
export function fetchInitData() {
  return request({
    url: `/finance/currencyRate/initData`,
    method: 'delete'
  });
}
