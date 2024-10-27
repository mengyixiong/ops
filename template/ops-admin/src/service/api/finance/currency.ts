import { request } from '@/service/request';

/** get user list */
export function fetchGetList(params?: Finance.FinanceCurrency.SearchParams) {
  return request<Finance.FinanceCurrency.List>({
    url: '/finance/currency',
    method: 'get',
    params
  });
}

/** add */
export function fetchAdd(data?: Finance.FinanceCurrency.Currency) {
  return request({
    url: '/finance/currency',
    method: 'post',
    data
  });
}

/** edit */
export function fetchEdit(id: number, data?: Finance.FinanceCurrency.Currency) {
  return request({
    url: `/finance/currency/${id}`,
    method: 'put',
    data
  });
}

/** edit */
export function fetchDel(id: number) {
  return request({
    url: `/finance/currency/${id}`,
    method: 'delete'
  });
}
