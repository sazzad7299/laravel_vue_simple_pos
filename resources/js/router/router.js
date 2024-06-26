import { createRouter, createWebHistory } from "vue-router";
import routes from "./routes";
import { userStore } from "../stores/user";
import { permissionStore } from "../stores/permission";

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior() {
    return { x: 0, y: 0 };
  },
});

const checkPermissions = (to, permission) => {
  if (to.name !== "dashboard" && !permission.includes(to.name)) {
    toastr.error("You do not have permission to access this page", "Sorry");
    return { name: "dashboard" };
  } else {
    if (to.meta && to.meta.title) {
      document.title = to.meta.title + " | App Name";
    }
    return true;
  }
};

router.beforeEach((to, from, next) => {
  const store = userStore();
  store.getUserFromLocalStorage();
  const permission = permissionStore();

  const isLoggedIn = store.isLoggedIn;
  const requiresAuth = to.meta.requiresAuth;
  const ignorePermission = to.meta.ignore;

  if (requiresAuth && !isLoggedIn) {
      next({ name: "login" });
    toastr.error("Login first", "Sorry");
  } else if ((to.name === "login" ||to.name === "register") && isLoggedIn) {
    next({ name: "dashboard" });
  }  else if(requiresAuth && isLoggedIn  && ignorePermission ){
      axios
        .get('/get-permissions')
        .then((response) => {
            permission.setPermissions(response.data.result);
        })
        .catch((error) => {
            console.log(error);
        });

      next();
  }
    else if (requiresAuth && isLoggedIn ) {
    axios
        .get('/get-permissions')
        .then((response) => {
            permission.setPermissions(response.data.result);
            const result = checkPermissions(to, response.data.result);
            if (result === true) {
                next();
            } else {
                next(result);
            }
        })
        .catch((error) => {
            console.log(error);
        });
} else {
    next();
}
});

router.afterEach((to) => {
  if (to.meta && to.meta.title) {
    document.title = to.meta.title + " | App Name";
  }
});
router.addRoute({
  path: '/:pathMatch(.*)*',
  name: 'notFound',
       component: () => import('../components/errors/404.vue'),
      meta: {
          title: '404',
          isGuest: true
      } // Replace with the actual component for your 404 page
});


export default router;
