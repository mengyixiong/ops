import { request } from '@/service/request';

/** get user list */
export function fetchGetList(params?: Finance.accountSubject.SearchParams) {
  return request<Finance.accountSubject.List>({
    url: '/finance/accountSubject',
    method: 'get',
    params
  });
}

export function fetchGetOperateInitData() {
  return request<Finance.accountSubject.Item>({
    url: `/finance/accountSubject/operateInitData`,
    method: 'get'
  });
}

/** add */
export function fetchAdd(data?: Finance.accountSubject.Item) {
  return request({
    url: '/finance/accountSubject',
    method: 'post',
    data
  });
}

/** edit */
export function fetchEdit(id: number, data?: Finance.accountSubject.Item) {
  return request({
    url: `/finance/accountSubject/${id}`,
    method: 'put',
    data
  });
}

/** edit */
export function fetchDel(id: number) {
  return request({
    url: `/finance/accountSubject/${id}`,
    method: 'delete'
  });
}
