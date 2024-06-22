export default defineNuxtRouteMiddleware((to, from) => {

    const authStore = useAuthStore();
    const route = useRoute();
  
    if (authStore.getUserData && authStore.getUserData.id !== route.params.id) {
        return navigateTo('/error');
    }
  });