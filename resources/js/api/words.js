import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/words/list',
    method: 'get',
    params: query,
  });
}
export function fetchAll() {
  return request({
    url: '/words/all',
    method: 'get',
  });
}

export function createWord(data) {
  return request({
    url: '/words/store',
    method: 'post',
    data,
  });
}

export function updateWord(data) {
  return request({
    url: '/words/update',
    method: 'post',
    data,
  });
}

export function deleteWord(data) {
  return request({
    url: '/words/destroy',
    method: 'post',
    data,
  });
}
