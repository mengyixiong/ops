import { request } from '@/service/request';
/** get company list */
export function fetchGetCompanyList(params?: Setting.SystemCompany.SearchParams) {
  return request<Setting.SystemCompany.List>({
    url: '/system/company',
    method: 'get',
    params
  });
}

/** add company */
export function fetchAdd(data?: Setting.SystemCompany.Form) {
  return request({
    url: '/system/company',
    method: 'post',
    data
  });
}

/** edit company */
export function fetchEdit(id: number, data?: Setting.SystemCompany.Form) {
  return request({
    url: `/system/company/${id}`,
    method: 'put',
    data
  });
}

/** edit company */
export function fetchDel(id: number) {
  return request({
    url: `/system/company/${id}`,
    method: 'delete'
  });
}
