import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/word-level/list',
    method: 'get',
    params: query,
  });
}

export function getLevels(myWordId = null) {
  return request({
    url: '/word-level/all' + '?myWordId=' + myWordId,
    method: 'get',
  });
}

export function createWordLevel(data) {
  return request({
    url: '/word-level/store',
    method: 'post',
    data,
  });
}

export function updateWordLevel(data) {
  return request({
    url: '/word-level/update',
    method: 'post',
    data,
  });
}

export function deleteWordLevel(data) {
  return request({
    url: '/word-level/destroy',
    method: 'post',
    data,
  });
}
