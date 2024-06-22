<script setup>
    const props = defineProps({
        id: {
            type: Number,
            default: NaN
        },
        isOpen: {
            type: Boolean,
            default: false
        },
    })

    const songStore = useSongStore();
    const alertStore = useAlertStore();

    const addSongToPlaylistDialog = ref(false);

    const openAddSongToPlaylistDialog = () => {
        addSongToPlaylistDialog.value = true;
    }

    const closeAddSongToPlaylistDialog = () => {
        addSongToPlaylistDialog.value = false;
    }

    const addQueue = () => {
        try {
            songStore.addToQueue(props.id);
            alertStore.successAlert('Đã thêm bài hát vào hàng chờ');
        } catch (error) {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        }
    }
</script>

<template>
    <div
        v-if="isOpen" 
        class="absolute w-[200px] py-[5px] top-full right-0 bg-[#17171b] text-[12px] text-white">
        <div
            @click="addQueue"  
            class="px-[20px] py-[3px] flex items-center cursor-pointer">
            <Icon name="i-ic:twotone-library-add" color="white" class="w-[14px] h-[14px] mr-2"/>
            Thêm vào hàng chờ
        </div>

        <div @click="openAddSongToPlaylistDialog" class="px-[20px] py-[3px] flex items-center cursor-pointer">
            <Icon name="i-ic:round-queue-music" color="white" class="w-[14px] h-[14px] mr-2"/>
            Thêm vào playlist
        </div>

        <!-- <div class="mt-2 h-[1px] bg-[#242529]"></div>

        <div class="px-[20px] py-[3px] flex items-center cursor-pointer">
            <Icon name="i-ic:baseline-share" color="white" class="w-[14px] h-[14px] mr-2"/>
            Share
        </div> -->

        <PlaylistList 
            :visible="addSongToPlaylistDialog" 
            :confirmClose="closeAddSongToPlaylistDialog"
            :id="id" 
        ></PlaylistList>
    </div>
</template>