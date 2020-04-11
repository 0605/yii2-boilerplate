import AdminLayout from '@admin/components/AdminLayout'

export default {
  path: '/shop-brand',
  component: AdminLayout,
  meta: {
    breadcrumb: {
      title: '商品品牌',
      path: '/shop-brand',
    },
  },
  children: [
    {
      path: '',
      component: () =>
        import(
          /* webpackChunkName: "chunk-shop" */ '@admin/views/shop-brand/Index'
        ),
    },
  ],
}
