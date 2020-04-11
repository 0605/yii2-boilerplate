import AdminLayout from '@admin/components/AdminLayout'

export default {
  path: '/user',
  component: AdminLayout,
  meta: {
    breadcrumb: {
      title: '用户',
      path: '/user',
    },
  },
  children: [
    {
      path: '',
      component: () =>
        import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Index'),
    },
    {
      path: 'create',
      component: () =>
        import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Create'),
      meta: {
        breadcrumb: {
          title: '新建用户',
        },
      },
    },
    {
      path: 'edit',
      component: () =>
        import(/* webpackChunkName: "chunk-user" */ '@admin/views/user/Edit'),
      meta: {
        breadcrumb: {
          title: '编辑用户',
        },
      },
    },
  ],
}
