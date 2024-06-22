import { defineStore } from "pinia";
import axios from 'axios';

export const useAuthStore = defineStore('auth', {
    state: () => ({
      currentUser: null,
      isLogged: false,
    }),

    getters: {
      getUserData() {
        return this.currentUser;
      },
      getDetailUserData() {
        return this.detailUser;
      },

      getLogged() {
          return this.isLogged;
      },

    },

    actions: {
        register(user) {
          return axios.post('http://127.0.0.1:8000/api/v1/users/register', user)
          .then((response) => {
              return response.data;
          })
          .catch(error => {
            throw error;
          })
        },

        setLoggedStatus() {
          if(localStorage.getItem('token'))
            {
              this.isLogged = true
            }
          else
            this.isLogged = false
        },
      
        login(credentials) {
            return axios.post('http://127.0.0.1:8000/api/v1/users/login', credentials)
            .then((response) => {
                this.isLogged = true;
                localStorage.setItem('token', response.data.data.token);
                localStorage.setItem('role', response.data.data.role);
        
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        upadateInfo(user) {
          const token = localStorage.getItem('token');
          return axios.post('http://127.0.0.1:8000/api/v1/users/update' + '?_method=PUT' , user.updateData, {
              headers: {
                  'Content-Type': 'multipart/form-data',
                  Authorization: `Bearer ${token}`
              }
          })
          .then((response) => {
              this.currentUser = response.data;
              return response.data;
          })
          .catch(error => {
              throw error;
          });
        },

        getInfo() {
          const token = localStorage.getItem('token');
          return axios.get('http://127.0.0.1:8000/api/v1/users/info', {
              headers: {
                  Authorization: `Bearer ${token}`
              }
          })
          .then((response) => {
              this.currentUser = response.data;
              return response.data;
          })
          .catch(error => {
              console.log(error);
          });
        },

        getDetail(id) {
          return axios.get('http://127.0.0.1:8000/api/v1/users/detail/' + id)
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
              console.log(error);
            })
        },

        getListUser() {
          return axios.get('http://127.0.0.1:8000/api/v1/users/list-user')
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
              console.log(error);
            })
        },

        getRemarkableUser() {
          return axios.get('http://127.0.0.1:8000/api/v1/users/most-songs')
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
              console.log(error);
            })
        },

        getNewUserByMonths() {
          return axios.get('http://127.0.0.1:8000/api/v1/users/new-users')
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
              console.log(error);
            })
        },

        getArtist() {
          return axios.get('http://127.0.0.1:8000/api/v1/users/artist')
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
              console.log(error);
            })
        },

        logout() {
          this.currentUser = '';
          localStorage.removeItem('token');
          localStorage.removeItem('role');
          this.isLogged = false;
          window.location.href = '/';
        }
      
    },
  });