// plugins/axios.js
import axios from 'axios';
import { useLoadingStore } from '~/stores/loading';

export default defineNuxtPlugin(() => {
  const loadingStore = useLoadingStore();

  const instance = axios.create({
    baseURL: 'http://localhost:3000', // Cấu hình URL API của bạn
  });

  instance.interceptors.request.use((config) => {
    loadingStore.setLoading(true);
    return config;
  });

  instance.interceptors.response.use(
    (response) => {
      loadingStore.setLoading(false);
      return response;
    },
    (error) => {
      loadingStore.setLoading(false);
      return Promise.reject(error);
    }
  );

  return {
    provide: {
      axios: instance,
    },
  };
});