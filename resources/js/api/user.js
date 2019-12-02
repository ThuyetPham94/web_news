import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/users/list',
    method: 'get',
    params: query,
  });
}

export function createUser(data) {
  return request({
    url: '/users/store',
    method: 'post',
    data,
  });
}

export function updateUser(data) {
  return request({
    url: '/users/update',
    method: 'post',
    data,
  });
}

export function deleteUser(data) {
  return request({
    url: '/users/destroy',
    method: 'post',
    data,
  });
}

export function updateField(data) {
  return request({
    url: '/users/update-field',
    method: 'post',
    data,
  });
}
