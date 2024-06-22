// stores/alertStore.js
import { defineStore } from 'pinia'

export const useAlertStore = defineStore('alert', {
  state: () => ({
    alertMessage: '',
    showAlert: false,
    status: false,
  }),
  actions: {
    successAlert(message) {
        this.showAlert = true;
        this.status = true;
        this.alertMessage = message;

        setTimeout(() => {
          this.showAlert = false;
        }, 3000);
    },

    errorAlert(message) {
      this.showAlert = true;
      this.status = false;
      this.alertMessage = message;

      setTimeout(() => {
        this.showAlert = false;
      }, 3000);
  }
  }
})