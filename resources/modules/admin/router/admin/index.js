import main from '@admin/views/layouts/Main'

const routes = [
  {
    path: '/admin',
    component: main,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "admin" */ '@admin/views/templates/admin/Index')
      }
    ]
  },
  {
    path: '/admin-group',
    component: main,
    children: [
      {
        path: '',
        component: () => import(/* webpackChunkName: "admin" */ '@admin/views/templates/admin-group/Index')
      },
      {
        path: 'view/:id',
        component: () => import(/* webpackChunkName: "admin" */ '@admin/views/templates/admin-group/View')
      }
    ]
  }
]

export default routes
