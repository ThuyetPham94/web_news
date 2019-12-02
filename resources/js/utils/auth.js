import Cookies from 'js-cookie';

const TokenKey = 'Admin-Token';
const UserKey = 'admin';

export function getToken() {
  return Cookies.get(TokenKey);
}

export function setToken(token) {
  return Cookies.set(TokenKey, token);
}

export function removeToken() {
  return Cookies.remove(TokenKey);
}

export function getUserInfor() {
  return localStorage.getItem(UserKey);
}

export function setUserInfor(user) {
  return localStorage.setItem(UserKey, JSON.stringify(user));
}

export function removeUser() {
  return localStorage.removeItem(UserKey);
}
