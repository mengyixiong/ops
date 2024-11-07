import { request } from '../request';

/**
 * Login
 */
export function fetchSend() {
  return request({
    url: '/chat/send',
    method: 'post'
  });
}
