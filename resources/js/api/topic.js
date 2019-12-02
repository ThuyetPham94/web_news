import request from '@/utils/request';

export function fetchList(query) {
  return request({
    url: '/topic/list',
    method: 'get',
    params: query,
  });
}

export function createTopic(data) {
  return request({
    url: '/topic/store',
    method: 'post',
    data,
  });
}

export function updateTopic(data) {
  return request({
    url: '/topic/update',
    method: 'post',
    data,
  });
}

export function deleteTopic(data) {
  return request({
    url: '/topic/destroy',
    method: 'post',
    data,
  });
}

export function getTopic() {
  return request({
    url: '/topic/all',
    method: 'get',
  });
}
