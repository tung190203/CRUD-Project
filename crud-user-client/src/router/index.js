import {createRouter, createWebHistory} from "vue-router";
import {route} from "./router.js";
import {LOCAL_STORAGE_KEY} from "@/constants/index.js";
import {useUserStore} from "@/stores/auth.js";
import {computed} from "vue";

const router = createRouter({
  history: createWebHistory(),
  routes: route
});

router.beforeEach((to, from, next) => {
  const loginToken = localStorage.getItem(LOCAL_STORAGE_KEY.LOGIN_TOKEN);
  const excludedRoutes = ["login", "register"];
  const userRole = getUserRole();
  if (!loginToken && !excludedRoutes.includes(to.name)) {
    next({name: "login", query: {redirect: to.fullPath}});
  } else if (loginToken && excludedRoutes.includes(to.name)) {
    next({name: "home"});
  } else {
    const requiredRoles = to.meta.roles;
    if (requiredRoles && !requiredRoles.includes(userRole)) {
      next({name: "home"});
    } else {
      next();
    }
  }
});

function getUserRole() {
  const userRole = computed(() => useUserStore().getUser);
  return userRole.value.role;
}

export default router;