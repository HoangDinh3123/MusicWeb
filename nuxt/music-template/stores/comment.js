import { defineStore } from "pinia";
import axios from 'axios';

export const useCommentStore = defineStore('comment', {
    state: () => ({
      listComment: null
    }),

    getters: {
        getListComment() {
            return this.listComment;
        } 
    },

    actions: {
        addComment(comment) {
            const token = localStorage.getItem('token');
            return axios.post('http://127.0.0.1:8000/api/v1/comments/post' , comment,
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
    },
  });