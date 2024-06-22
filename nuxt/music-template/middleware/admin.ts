export default defineNuxtRouteMiddleware(async (to, from) => {
    if (process.client) {
        const role = localStorage.getItem('role');
        
        if (role !== '1') {
          return navigateTo('/error');
        }
    }
  });