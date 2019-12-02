import Vue from 'vue';
import Router from 'vue-router';

// in development-env not use lazy-loading, because lazy-loading too many pages will cause webpack hot update too slow. so only in production use lazy-loading;
// detail: https://panjiachen.github.io/vue-element-admin-site/#/lazy-loading

Vue.use(Router);

/* Layout */
import Layout from '../views/layout/Layout';

/* Router for modules */
// import componentsRouter from './modules/components';
// import chartsRouter from './modules/charts';
// import tableRouter from './modules/table';
// import exampleRouter from './modules/example';
// import nestedRouter from './modules/nested';
// import errorRouter from './modules/error';
// import excelRouter from './modules/excel';
// import permissionRouter from './modules/permission';

/**
* hidden: true                   if `hidden:true` will not show in the sidebar(default is false)
* alwaysShow: true               if set true, will always show the root menu, whatever its child routes length
*                                if not set alwaysShow, only more than one route under the children
*                                it will becomes nested mode, otherwise not show the root menu
* redirect: noredirect           if `redirect:noredirect` will no redirect in the breadcrumb
* name:'router-name'             the name is used by <keep-alive> (must set!!!)
* meta : {
    title: 'title'               the name show in submenu and breadcrumb (recommend set)
    icon: 'svg-name'             the icon show in the sidebar
    breadcrumb: false            if false, the item will hidden in breadcrumb(default is true)
  }
**/
export const constantRouterMap = [
  {
    path: '/redirect',
    component: Layout,
    hidden: true,
    children: [
      {
        path: '/redirect/:path*',
        component: () => import('@/views/redirect/index'),
      },
    ],
  },
  {
    path: '/login',
    component: () => import('@/views/login/index'),
    hidden: true,
  },
  {
    path: '/auth-redirect',
    component: () => import('@/views/login/AuthRedirect'),
    hidden: true,
  },
  {
    path: '/404',
    redirect: { name: 'Page404' },
    component: () => import('@/views/ErrorPage/404'),
    hidden: true,
  },
  {
    path: '/401',
    component: () => import('@/views/ErrorPage/401'),
    hidden: true,
  },
  {
    path: '',
    component: Layout,
    redirect: 'dashboard',
    children: [
      {
        path: 'dashboard',
        component: () => import('@/views/dashboard/index'),
        name: 'Dashboard',
        meta: { title: 'Thống kê', icon: 'dashboard', noCache: true, roles: ['admin'] },
      },
    ],
  },
  {
    path: '/topic',
    component: Layout,
    redirect: '/topic/all',
    children: [
      {
        path: 'all',
        component: () => import('@/views/topic/index'),
        name: 'Topic',
        meta: { title: 'Topic', icon: 'dashboard', roles: ['admin'] },
      },
    ],
  },
  {
    path: '/words',
    component: Layout,
    redirect: '/words/index',
    meta: { title: 'Từ vựng', icon: 'dashboard', roles: ['admin'] },
    children: [
      {
        path: 'index',
        component: () => import('@/views/words/index'),
        name: 'Words',
        meta: { title: 'Danh sách', icon: 'dashboard', roles: ['admin'] },
      },
      {
        path: 'level',
        component: () => import('@/views/words/level'),
        name: 'Level',
        meta: { title: 'Kho từ', icon: 'dashboard', roles: ['admin'] },
      },
    ],
  },
  {
    path: '/user',
    component: Layout,
    redirect: '/words/list',
    children: [
      {
        path: 'list',
        component: () => import('@/views/user/index'),
        name: 'User',
        meta: { title: 'User', icon: 'dashboard', roles: ['admin'] },
      },
      {
        path: '/student',
        component: () => import('@/views/user/student'),
        name: 'student',
        meta: { title: 'Học sinh', roles: ['admin'] },
        hidden: true,
      },
    ],
  },
  {
    path: '/game',
    component: Layout,
    redirect: '/game/list',
    meta: { title: 'Trò chơi', icon: 'dashboard', roles: ['admin'] },
    children: [
      {
        path: 'index',
        component: () => import('@/views/game/index'),
        name: 'Words',
        meta: { title: 'Danh sách game', icon: 'dashboard', roles: ['admin'] },
      },
      {
        path: 'list',
        component: () => import('@/views/game_context/index'),
        name: 'game',
        meta: { title: 'Trò chơi bối cảnh', icon: 'dashboard', roles: ['admin'] },
      },
      {
        path: 'update',
        component: () => import('@/views/game_context/update'),
        name: 'update-game',
        hidden: true,
        meta: { title: 'Cập nhập trò chơi', icon: 'dashboard', roles: ['admin'] },
      },
    ],
  },
];

export default new Router({
  // mode: 'history', // Require service support
  scrollBehavior: () => ({ y: 0 }),
  routes: constantRouterMap,
});

export const asyncRouterMap = [];
