import blank from '@admin/views/layouts/Blank'

const routes = [
  {
    path: '/auth',
    component: blank,
    children: [
      {
        path: 'login',
        component: () => import(/* webpackChunkName: "auth" */ '@admin/views/templates/auth/Login')
      }
    ]
  }
]

export default routes
