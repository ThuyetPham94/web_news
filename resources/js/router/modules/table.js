/** When your routing table is too long, you can split it into small modules**/

import Layout from '@/views/layout/Layout';

const tableRouter = {
  path: '/table',
  component: Layout,
  redirect: '/table/complex-table',
  name: 'Complex Table',
  meta: {
    title: 'Table',
    icon: 'table',
  },
  children: [
    {
      path: 'complex-table',
      component: () => import('@/views/table/ComplexTable'),
      name: 'ComplexTable',
      meta: { title: 'complexTable' },
    },
    {
      path: 'dynamic-table',
      component: () => import('@/views/table/DynamicTable/index'),
      name: 'DynamicTable',
      meta: { title: 'dynamicTable' },
    },
  ],
};
export default tableRouter;
