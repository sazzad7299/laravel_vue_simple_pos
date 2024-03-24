let store = [
  {
    path: "/product",
    name: "product.index",
    component: () => import("../pages/product/index.vue"),
    meta: {
      title: "product List",
      requiresAuth: true,
    },
  },
  {
    path: "/product/create",
    name: "product.create",
    component: () => import("../pages/product/create.vue"),
    meta: {
      title: "Create product",
      requiresAuth: true,
    },
  },
  {
    path: "/product/:id/edit",
    name: "product.edit",
    component: () => import("../pages/product/edit.vue"),
    meta: {
      title: "Edit product",
      requiresAuth: true,
    },
  },
  {
    path: "/product/:id/view",
    name: "product.view",
    component: () => import("../pages/product/View.vue"),
    meta: {
      title: "product Info",
      requiresAuth: true,
    },
  },
  {
    path: "/pos",
    name: "sale.create",
    component: () => import("../pages/pos/create.vue"),
    meta: {
      title: "POS",
      requiresAuth: true,
    },
  },
  {
    path: "/sale/list",
    name: "sale.index",
    component: () => import("../pages/sale/index.vue"),
    meta: {
      title: "Sale List",
      requiresAuth: true,
    },
  },
  {
    path: "/sale/:id/view",
    name: "sale.view",
    component: () => import("../pages/sale/view.vue"),
    meta: {
      title: "View Sale",
      requiresAuth: true,
    },
  },
];
export default store;
