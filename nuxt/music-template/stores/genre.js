import { defineStore } from "pinia";
import axios from 'axios';

export const useGenreStore = defineStore('genre', {
    state: () => ({
      listGenre: null
    }),

    getters: {
        getListGenre() {
            return this.listGenre;
        } 
    },

    actions: {
        getAllGenre() {
            return axios.get('http://127.0.0.1:8000/api/v1/genres/index')
            .then((response) => {
                this.listGenre = response.data.data;
                return response.data.data;
            })
            .catch(error => {
              console.log(error);
            })
        },

        getDetailGenre(id) {
            return axios.get('http://127.0.0.1:8000/api/v1/genres/detail/' + id)
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
              console.log(error);
            })
        },

        addGenre(genre) {
            console.log(genre);
            const token = localStorage.getItem('token');

            return axios.post('http://127.0.0.1:8000/api/v1/genres/add', genre,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                this.listGenre.push(response.data.data);
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        editGenre(id, genre) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/genres/edit/' + id + '?_method=PUT', genre,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                const selectedGenre = this.listGenre.findIndex(item => item.id == id);
                this.listGenre[selectedGenre] = response.data.data;
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        deleteGenre(id) {
            console.log(id);
            const token = localStorage.getItem('token');
            return axios.delete('http://127.0.0.1:8000/api/v1/genres/delete/' + id,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                const index = this.listGenre.findIndex(item => item.id === id);
                if (index !== -1) {
                    this.listGenre.splice(index, 1);
                }
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },
    },
  });