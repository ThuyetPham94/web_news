import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/game-contect/list',
    method: 'get',
    params: query,
  });
}

export function createGame(data) {
  return request({
    url: '/game-contect/store',
    method: 'post',
    data,
  });
}

export function updateGame(data) {
  return request({
    url: '/game-contect/update',
    method: 'post',
    data,
  });
}

export function deleteGame(data) {
  return request({
    url: '/game-contect/destroy',
    method: 'post',
    data,
  });
}

export function findGame(data) {
  return request({
    url: '/game-contect/find',
    method: 'post',
    data,
  });
}

export function uploadImage(data) {
  return request({
    url: '/upload-img',
    method: 'post',
    data,
  });
}
