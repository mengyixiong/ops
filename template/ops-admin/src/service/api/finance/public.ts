import { request } from '@/service/request';

/** edit */
export function fetchGetInitData() {
  return request({
    url: `/finance/public/getInitData`,
    method: 'get'
  });
}
