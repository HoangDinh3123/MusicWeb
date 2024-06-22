<script setup>
    const emits = defineEmits(['update']);
    const props = defineProps({
        playlist: {
            type: Object,
            default: () => ({})
        },
        visible: {
            type: Boolean,
            default: false
        },
        confirmClose: {
            type: Function
        },
    })

    const playlistStore = usePlaylistStore();
    const authStore = useAuthStore();
    const alertStore = useAlertStore();

    const name = ref('');
    
    if(props.playlist !== null) {
        name.value = props.playlist.name;
    }

    const add = () => {
        playlistStore.addPlaylist(
            authStore.currentUser.id,
            {
                name: name.value
            }
        ).then(() => {
            emits('update');
            alertStore.successAlert('Đã thêm playlist thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }

    const edit = () => {
        playlistStore.updatePlaylist(
            props.playlist.id,
            {
                name: name.value
            }
        ).then(() => {
            emits('update');
            alertStore.successAlert('Đã cập nhật playlist thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }
</script>

<template>
    <div 
        v-if="visible" 
        class="fixed pt-[200px] z-[20] left-[0px] top-[0px] w-full h-full overflow-auto bg-[rgb(110,107,107)] bg-[rgba(0,0,0,0.4)]"
    >

        <div class="bg-[#fefefe] mx-auto px-[26px] py-[80px] border border-[#888] w-full md:w-[500px] rounded-md" >
            <form @submit.prevent="playlist.id ? edit() : add()">
                <div>
                    <input 
                        v-model="name"
                        type="text" 
                        placeholder="Tên Playlist" 
                        class="w-full py-[20px] px-2 border focus:outline-none rounded-b-md">
                </div>

                <div class="mt-[40px] flex justify-center ">
                    <div @click="confirmClose" class="close w-[120px] h-[40px] rounded-md border border-[#00000033] text-[#00000033] flex items-center justify-center cursor-pointer">No</div>
                    <button class="w-[120px] h-[40px] ml-[25px] rounded-md bg-[#f44336] text-white">Yes</button>
                </div>
            </form>
        </div>

    </div>
</template>