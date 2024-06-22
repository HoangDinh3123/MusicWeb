<script setup>
    import { useRoute } from 'vue-router';
    import authImage from '~/assets/images/auth.jpg';

    const route = useRoute();
    const playlistStore = usePlaylistStore();
    const songStore = useSongStore();
    const alertStore = useAlertStore();

    const image = ref(authImage);
    const songs = ref([]);

    const detailPlaylist = ref(null);

    const updateImageAndSongs = () => {
        if (detailPlaylist.value && detailPlaylist.value.songs.length > 0) {
            image.value = detailPlaylist.value.songs[0].image;
            songs.value = detailPlaylist.value.songs;
        }
    };

    onMounted(async () => {
        detailPlaylist.value = await playlistStore.getDetailPlaylist(route.params.id);
        updateImageAndSongs();
    });

    const deleteSong = (id) => {
        playlistStore.deleteSongPlaylist({
            playlist_id: detailPlaylist.value.id,
            song_id: id 
        })
        .then(() => {
            const index = songs.value.findIndex(item => item.id === id);

            if (index !== -1) {
                songs.value.splice(index, 1);
            }

            alertStore.successAlert('Đã xóa bài hát khỏi playlist thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }

    const playPlaylist = () => {
        if(detailPlaylist.value.songs.length > 0) {
            songStore.addPlaylistToQueue(detailPlaylist.value.songs);
        }
    }

</script>

<template>
    <div>
        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-10">
            <div class="col-span-3 text-center">
                <img :src="image" alt="" class="w-full h-[300px] rounded-md">
                <p class="text-[20px] my-2">{{ detailPlaylist?.name }}</p>

                <button 
                    @click="playPlaylist" 
                    class="px-5 py-2 bg-slate-400 rounded-lg hover:text-white transition-all">
                    <span>PHÁT</span>
                </button>
            </div>

            <div class="col-span-9 mt-8 lg:m-0">
                <h1 class="font-bold text-[20px]">DANH SÁCH BÀI HÁT <span></span></h1>

                <div 
                    v-for="(item, index) in songs"
                    :key="index"
                    class="h-[84px] flex items-center"
                >
                    <SongHorizon
                        :order="index"
                        :song="item"
                        class="h-[84px]">
                    </SongHorizon>

                    <button @click="deleteSong(item.id)">
                        <Icon name="i-mdi:alpha-x-circle-outline" color="black" class="w-[30px] h-[30px]"/>
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>
