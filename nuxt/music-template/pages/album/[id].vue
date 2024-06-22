<script setup>
    import { useRoute } from 'vue-router';

    const route = useRoute();
    const albumStore = useAlbumStore();
    const songStore = useSongStore();

    const image = ref(null);
    const songs = ref([]);

    const detailAlbum = ref(null);

    const addDialog = ref(false);

    onMounted(async () => {
        detailAlbum.value = await albumStore.getDetailAlbum(route.params.id);
        image.value = detailAlbum.value.image;
        songs.value = detailAlbum.value.songs;
    });

    const deleteSong = (id) => {
        playlistStore.deleteSongPlaylist({
            playlist_id: detailPlaylist.value.id,
            song_id: id 
        });

        const index = songs.value.findIndex(item => item.id === id);

        if (index !== -1) {
            songs.value.splice(index, 1);
        }
    }

    const handleSongAdd = async (newSong) => {
        if (newSong) {
            songs.value.push(newSong);
        }
        addDialog.value = false;
    };

    const handleSongUpdate = async (songSelected) => {
        const index = songs.value.findIndex(item => item.id === songSelected.id);
        if (index !== -1) {
            // Thay thế bài hát cũ bằng bài hát mới
            songs.value.splice(index, 1, songSelected);
        }
    }

    const handleSongDelete = async (songSelected) => {
        const index = songs.value.findIndex(item => item.id === songSelected);
        if (index !== -1) {
            songs.value.splice(index, 1);
        }
    }

    const openAddDialog = () => {
        addDialog.value = true;
    }

    const closeAddDialog = () => {
        addDialog.value = false;
    }

</script>

<template>
    <div>
        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-10">
            <div class="col-span-3 text-center">
                <img :src="image" alt="" class="w-full h-[300px] rounded-md">
                <p class="text-[20px] my-2">{{ detailAlbum?.name }}</p>

                <button 
                    @click="openAddDialog" 
                    class="px-5 py-2 bg-slate-400 rounded-lg hover:text-white transition-all">
                    <span>Thêm bài hát</span>
                </button>
            </div>

            <div class="col-span-9 mt-8 lg:m-0">
                <h1 class="font-bold text-[20px]">DANH SÁCH BÀI HÁT <span></span></h1>

                <div v-if="songs.length == 0">
                    Ban chua co bai hat nao
                </div>

                <div 
                    v-for="(item, index) in songs"
                    :key="index"
                    class="h-[144px]"
                >
                    <SongProfile 
                        :song="item"
                        @songDeleted="handleSongDelete"
                        @songUpdated="handleSongUpdate"
                        >
                    </SongProfile>
                </div>
            </div>
        </div>

        <SongAddOrUpdate :confirmClose="closeAddDialog" :visible="addDialog" :album_id="detailAlbum?.id" @update="handleSongAdd"></SongAddOrUpdate>
    </div>
</template>
