export default defineNuxtRouteMiddleware((to, from) => {
  const authStore = useAuthStore();

  if (!authStore.isLogged) {
    return navigateTo('/auth/login');
  }
});