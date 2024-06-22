<script setup>
    const props = defineProps({
        id: {
            type: Number,
        },
        visible: {
            type: Boolean,
            default: false
        },
        confirmClose: {
            type: Function
        },
    })

    const authStore = useAuthStore();
    const playlistStore = usePlaylistStore();
    const alertStore = useAlertStore();
    const listPlaylist = ref([]);
    
    onMounted(async () => {
        if(authStore.currentUser) {
            await playlistStore.getAllPlaylist(authStore.currentUser.id);
            listPlaylist.value = playlistStore.getListPlaylist;
        }
    })

    const add = async (playlist) => {
        try{
            await playlistStore.addSongToPlaylist({
                playlist_id: playlist,
                song_id: props.id
            });

            props.confirmClose();
            alertStore.successAlert('Đã thêm bài hát vào playlist');
        } catch(error) {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        }
    }
    
</script>

<template>
    <div 
        v-if="visible" 
        class="fixed pt-[200px] z-[20] left-[0px] top-[0px] w-full h-full overflow-auto bg-[rgb(110,107,107)] bg-[rgba(0,0,0,0.4)]"
    >

        <div class="bg-[#fefefe] mx-auto px-[26px] pt-[40px] pb-[80px] border border-[#888] w-full md:w-[500px] rounded-md" >
            <h3 
                v-if="listPlaylist.length == 0"
                class="text-black text-center text-[20px]">
                Bạn không có playlist nào!
            </h3>

            <div v-else>
                <ul>
                    <li 
                        v-for="item in listPlaylist"
                        :key="item"
                        @click="add(item.id)"
                        class="flex justify-between text-black text-[14px] p-[10px] hover:bg-slate-300 rounded-sm transition-all cursor-pointer">
                        <div>
                            <Icon name="i-ic:baseline-library-music" color="black" class="w-[20px] h-[20px] mr-2" />
                            {{item.name}}
                        </div>

                        <span>{{ item.songs.length }} bài hát</span>
                    </li>
                </ul>
            </div>

            <div class="mt-[40px] flex justify-center ">
                <button @click="confirmClose" class="close w-[120px] h-[40px] rounded-md border border-[#00000033] text-[#00000033]">Hủy</button>
            </div>
        </div>

    </div>
</template>