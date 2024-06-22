import { defineStore } from "pinia";
import axios from 'axios';

export const useSongStore = defineStore('song', {
    state: () => ({
        listSong: [],
        currentSong: '',
        queue: [],
        likedSong: [],
        listUserSong: [],
    }),

    getters: {
        getListSong() {
            return this.listSong;
        },
        getCurrentSong() {
            return this.currentSong;
        },
        getListUserSong() {
            return this.listUserSong;
        },
        getQueue() {
            return this.queue;
        },
        getListLikedSong() {
            return this.likedSong;
        },
    },

    actions: {
        async getSong() {
            let songId = '';
            if(typeof localStorage !== 'undefined' && localStorage.getItem('currentSong')) {
                songId = localStorage.getItem('currentSong');

                 await this.setCurrentSong(songId);
            }
        },

        setCurrentSong(id) {
            const token = localStorage.getItem('token');
        
            const url = token ?
                'http://127.0.0.1:8000/api/v1/songs/detail-with-user/' :
                'http://127.0.0.1:8000/api/v1/songs/';

            return axios.get(url + id, {
                headers: token ? { Authorization: `Bearer ${token}` } : {}
            })
            .then((response) => {
                localStorage.setItem('currentSong', response.data.data.song.id);
                this.currentSong = response.data.data.song;

                //kiem tra xem da trong queue chua
                const existingSongIndex = this.queue.findIndex(item => item.id === response.data.data.song.id);

                if (existingSongIndex === -1) {
                    // Nếu mục không tồn tại trong hàng chờ, thêm vào
                    this.queue.push(this.currentSong);
                    localStorage.setItem('queue', JSON.stringify(this.queue));
                }

                return response.data.data;
            })
            .catch(error => {
                console.log(error);
            })
        },

        setQueue() {
             this.queue = JSON.parse(localStorage.getItem('queue')) || [];
        },
        checkExisting(id) {
            return this.queue.findIndex(item => item.id === id);
        },

        async addToQueue(id) {
            try{
                //kiem tra xem da trong queue chua
                const existingSongIndex = this.queue.findIndex(item => item.id === id);

                if (existingSongIndex === -1) {
                    const song = await this.getSongById(id);
                    if(song !== null) {
                        this.queue.push(song.song);
                        this.currentSong = song.song;

                        localStorage.setItem('queue', JSON.stringify(this.queue));
                        localStorage.setItem('currentSong', song.song.id);
                    }
                }
            } catch(error) {
                throw error;
            };
        },

        addPlaylistToQueue(songs) {
            songs.forEach(song => {
                const check = this.checkExisting(song.id);
                if(this.checkExisting(song.id) === -1) {
                    this.queue.push(song);
                }
            });

            localStorage.setItem('currentSong', songs[0].id);
            this.currentSong = songs[0];
            localStorage.setItem('queue', JSON.stringify(this.queue));
        },

        deleteSongQueue(id) {
            const existingSongIndex = this.queue.findIndex(item => item.id === id);
            if (existingSongIndex !== -1) {
                this.queue.splice(existingSongIndex, 1);
                localStorage.setItem('queue', JSON.stringify(this.queue));
            }
        },

        getAllSong() {
            const token = localStorage.getItem('token');
        
            const url = token ?
                'http://127.0.0.1:8000/api/v1/songs/list-song' :
                'http://127.0.0.1:8000/api/v1/songs/index';
        
            return axios.get(url, {
                    headers: token ? { Authorization: `Bearer ${token}` } : {}
                })
                .then(response => {
                    this.listSong = response.data.data;
                    return response.data.data;
                })
                .catch(error => {
                    console.log(error);
                });
        },
        
        getSongById(id) {
            return axios.get('http://127.0.0.1:8000/api/v1/songs/' + id)
            .then((response) => {
                console.log(response.data.data);
                return response.data.data;
            })
            .catch(error => {
                console.log(error);
            })
        },

        getSongByUser(id) {
            return axios.get('http://127.0.0.1:8000/api/v1/songs/byUser/' + id)
            .then((response) => {
                this.listUserSong = response.data.data;
                return response.data.data;
            })
            .catch(error => {
                console.log(error);
            })
        },

        getLikedSong(id) {
            const token = localStorage.getItem('token');

            return axios.get('http://127.0.0.1:8000/api/v1/interactions/get-liked-song/' + id, 
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                for(let i = 0; i < response.data.data.length; i++) {
                    this.likedSong.push(response.data.data[i][0]);
                }
                return response.data.data;
            })
            .catch(error => {
                console.log(error);
            })
        },

        add(song) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/songs/add', song,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                this.listUserSong.push(response.data.data);
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        delete(id) {
            const token = localStorage.getItem('token');
            return axios.delete('http://127.0.0.1:8000/api/v1/songs/delete/'+ id,
                {
                    headers: {
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                const index = this.listUserSong.findIndex(item => item.id === id);
                if (index !== -1) {
                    this.listUserSong.splice(index, 1);
                }
                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        edit(id, user_id, songUpdated) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/songs/update/' + id + '?_method=PUT', songUpdated.updateData,
                {
                    headers: {
                        'Content-Type': 'multipart/form-data',
                        Authorization: `Bearer ${token}`
                    }
                }
            )
            .then((response) => {
                const songIndex = this.listUserSong.findIndex(song => song.id === id);
                if (songIndex !== -1) {
                    this.listUserSong[songIndex] = {
                        ...this.listUserSong[songIndex],
                        ...response.data.data
                    }
                }

                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        like(data) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/interactions/like/', data,
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
            .then((response) => {
                //thay doi trang thai like o list bai hat
                const index = this.listSong.findIndex(item => item.id === data.song_id);
                if (index !== -1) {
                    this.listSong[index].liked_by_user = response.data.data;
                }

                //thay doi trang thai like o current song
                if(this.currentSong.id === data.song_id)
                {
                    this.currentSong.liked_by_user = response.data.data;
                }

                if(response.data.data)
                {
                    this.likedSong.push(this.listSong[index]);
                }
                else {
                    const existingIndex = this.likedSong.findIndex(item => item.id == data.song_id);
                    if (existingIndex !== -1) {
                        this.likedSong.splice(existingIndex, 1);
                    }
                }

                return response.data.data;
            })
            .catch(error => {
                throw error;
            })
        },

        play(data) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/interactions/play', data,
            {
                headers: {
                    Authorization: `Bearer ${token}`
                }
            })
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
                console.log(error);
            })
        },

        getTrendingSong() {
            return axios.get('http://127.0.0.1:8000/api/v1/songs/trending-songs')
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
                console.log(error);
            })
        },

        getNewSong() {
            return axios.get('http://127.0.0.1:8000/api/v1/songs/new-songs')
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
                console.log(error);
            })
        },

        search(keyword) {
            return axios.post('http://127.0.0.1:8000/api/v1/songs/search', keyword)
            .then((response) => {
                return response.data.data;
            })
            .catch(error => {
                console.log(error);
            })
        }

    },
});
