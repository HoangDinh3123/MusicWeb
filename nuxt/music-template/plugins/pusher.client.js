import Pusher from 'pusher-js';

export default defineNuxtPlugin(nuxtApp => {
  const pusher = new Pusher('ab29134fdc1c6282219d', {
    cluster: 'ap1'
  });

  nuxtApp.provide('pusher', pusher);
});