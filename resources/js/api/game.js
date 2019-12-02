import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/game/list',
    method: 'get',
    params: query,
  });
}
export function fetchAll() {
  return request({
    url: '/game/all',
    method: 'get',
  });
}

export function createGame(data) {
  return request({
    url: '/game/store',
    method: 'post',
    data,
  });
}

export function updateGame(data) {
  return request({
    url: '/game/update',
    method: 'post',
    data,
  });
}

export function deleteGame(data) {
  return request({
    url: '/game/destroy',
    method: 'post',
    data,
  });
}
