import { defineStore } from "pinia";
import axios from 'axios';

export const useAlbumStore = defineStore('album', {
    state: () => ({
      listAlbum: [],
    }),

    getters: {
        getListAlbum() {
            return this.listAlbum;
        },
    },

    actions: {
        getAllAlbum(id) {
            const token = localStorage.getItem('token');
            return axios.get('http://127.0.0.1:8000/api/v1/albums/get/' + id ,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                this.listAlbum = response.data.data;
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        getDetailAlbum(id) {
            const token = typeof window !== 'undefined' ? localStorage.getItem('token') : null;
            return axios.get('http://127.0.0.1:8000/api/v1/albums/detail/' + id ,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        addAlbum(album) {
            console.log(album);
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/albums/add', album ,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                this.listAlbum.push(response.data.data);
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        updateAlbum(id, album) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/albums/edit/' + id + '?_method=PUT', album ,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                const selectedAlbum = this.listAlbum.findIndex(item => item.id == id);
                this.listAlbum[selectedAlbum] = response.data.data;
                return response.data.data;
            })
            .catch(error => {
              throw error;
            })
        },

        deleteAlbum(id) {
            const token = localStorage.getItem('token');
            return axios.delete('http://127.0.0.1:8000/api/v1/albums/delete/' + id,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                const index = this.listAlbum.findIndex(item => item.id === id);
                if (index !== -1) {
                    this.listAlbum.splice(index, 1);
                }
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },
    },
  });