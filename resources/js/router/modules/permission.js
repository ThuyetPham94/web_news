/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/views/layout/Layout';

const permissionRouter = [
  {
    path: '',
    component: Layout,
    redirect: '/permission/index',
    alwaysShow: true, // will always show the root menu
    meta: {
      title: 'permission',
      icon: 'lock',
      roles: ['cashier'], // you can set roles in root nav
    },
    children: [
      {
        path: 'page',
        component: () => import('@/views/permission/Page'),
        name: 'PagePermission',
        meta: {
          title: 'Thanh Toán',
          icon: 'guide',
          roles: ['cashier'],
        },
      },
    ],
  },
  {
    path: '',
    component: Layout,
    redirect: '/history/index',
    alwaysShow: false,
    children: [
      {
        path: 'page',
        component: () => import('@/views/permission/Page'),
        name: 'PagePermission',
        meta: {
          title: 'Lịch sử',
          icon: 'guide',
          roles: ['cashier'],
        },
      },
    ],
  },
];

export default permissionRouter;
