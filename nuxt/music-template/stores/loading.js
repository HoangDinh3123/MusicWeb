import { defineStore } from "pinia";
import axios from 'axios';

export const useLoadingStore = defineStore('loading', {
    state: () => ({
      loading: false,
    }),

    getters: {
        getIsLoading() {
            return this.loading;
        },
    },

    actions: {
        setLoading(status) {
            this.loading = status;
        }
    },
  });