import { request } from '@/service/request';
/** get user list */
export function fetchGetCompanyList(params?: AdminCompany.SearchParams) {
  return request<AdminCompany.SearchParams>({
    url: '/system/company',
    method: 'get',
    params
  });
}
