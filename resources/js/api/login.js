import request from '@/utils/request';

export function login(email, password) {
  return request({
    url: '/admin/auth/login',
    method: 'post',
    data: {
      email,
      password,
    },
  });
}

export function getInfo(token) {
  return request({
    url: '/auth/user',
    method: 'get',
  });
}

export function logout() {
  return request({
    url: '/auth/logout',
    method: 'post',
  });
}

export function getMasterData() {
  return request({
    url: '/master-data',
    method: 'get',
  });
}
