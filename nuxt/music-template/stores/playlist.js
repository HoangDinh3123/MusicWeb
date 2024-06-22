import { defineStore } from "pinia";
import axios from 'axios';

export const usePlaylistStore = defineStore('playlist', {
    state: () => ({
      listPlaylist: [],
    }),

    getters: {
        getListPlaylist() {
            return this.listPlaylist;
        },
    },

    actions: {
        getAllPlaylist(id) {
            const token = localStorage.getItem('token');
            return axios.get('http://127.0.0.1:8000/api/v1/playlists/get/' +id ,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                this.listPlaylist = response.data.data;
                return response.data.data;
            })
            .catch(error => {
              console.log(error);
            })
        },

        getDetailPlaylist(id) {
            const token = typeof window !== 'undefined' ? localStorage.getItem('token') : null;
            return axios.get('http://127.0.0.1:8000/api/v1/playlists/detail/' + id ,
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
              console.log(error);
            })
        },

        addPlaylist(id, playlist) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/playlists/add/' + id, playlist ,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                this.listPlaylist.push(response.data.data);
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        updatePlaylist(id, playlist) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/playlists/edit/' + id + '?_method=PUT', playlist ,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                const selectedPlaylist = this.listPlaylist.findIndex(item => item.id == id);
                this.listPlaylist[selectedPlaylist] = response.data.data;
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        deletePlaylist(id) {
            const token = localStorage.getItem('token');
            return axios.delete('http://127.0.0.1:8000/api/v1/playlists/delete/' + id,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                const index = this.listPlaylist.findIndex(item => item.id === id);
                if (index !== -1) {
                    this.listPlaylist.splice(index, 1);
                }
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        addSongToPlaylist(playlistSong) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/playlist-songs/add' , playlistSong,
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

        deleteSongPlaylist(playlistSong) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/playlist-songs/delete' , playlistSong,
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
        }
    },
  });