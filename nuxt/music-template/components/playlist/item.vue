<script setup>
    import authImage from '~/assets/images/auth.jpg';
    const props = defineProps({
        playlist: {
            type: Object,
            default: () => ({}) // Mặc định là một đối tượng trống nếu không có dữ liệu bài hát được truyền vào
        },
    })

    const songStore = useSongStore();

    const isSelected = ref(false);
    const deleteDialog = ref(false);
    const updatePlaylistDialog = ref(false);

    const image = ref(authImage);

    if(props.playlist.songs.length > 0)
    {
        image.value = props.playlist.songs[0].image;
    }

    const playPlaylist = () => {
        if(props.playlist.songs.length > 0) {
            songStore.addPlaylistToQueue(props.playlist.songs);
        }
    }

    const openDeleteDialog = () => {
        deleteDialog.value = true;
    }

    const closeDeleteDialog = () => {
        deleteDialog.value = false;
    }

    const openUpdatePlaylistDialog = () => {
        updatePlaylistDialog.value = true;
    }

    const closeUpdatePlaylistDialog = () => {
        updatePlaylistDialog.value = false;
    }
</script>

<template>
    <div 
        @mouseover="isSelected = true"
        @mouseleave="isSelected = false"
        class="w-full"
    >
        <div class="relative w-full after:block after:pt-[100%]">
            <img 
                :src="image"
                alt=""
                class="absolute top-0 left-0 w-full h-full bg-cover rounded-sm"
            >

            <div 
                :class="{'opacity-100': isSelected}"
                class="px-2 opacity-0 md:px-8 flex justify-between items-center absolute z-10 top-1/2 left-0 w-full transition-all"
            >
                <div
                    @click="openDeleteDialog"  
                    class="cursor-pointer"
                >
                    <Icon name="i-mdi:alpha-x-circle-outline" color="#d0d0d0" class="w-[30px] h-[30px] md:w-[35px] md:h-[35px]"/>
                </div>

                <div 
                    @click="playPlaylist"
                    class="flex justify-center items-center w-10 h-10 cursor-pointer border-2 rounded-full"
                >
                    <Icon name="i-mdi:play" color="#d0d0d0" class="w-[30px] h-[30px] md:w-[35px] md:h-[35px]"/>
                </div>

                <div 
                    @click="openUpdatePlaylistDialog"
                    class="cursor-pointer">
                    <Icon name="i-mdi:circle-edit-outline" color="#d0d0d0" class="w-[30px] h-[30px] md:w-[35px] md:h-[35px]"/>
                </div>
                
            </div>
        </div>

        <div class="w-full pt-[10px]">
            <NuxtLink :to="'/playlist/' + playlist.id" class="text-black text-[14px] line-clamp-1 block">{{ playlist.name }}</NuxtLink>
            <div 
                class="text-[#d0d0d0] text-[12.8px] block"
            >
                {{ playlist.songs.length }} bài hát
            </div>
        </div>

        <PlaylistUpdate :confirmClose="closeUpdatePlaylistDialog" :visible="updatePlaylistDialog" :playlist="playlist" @update="closeUpdatePlaylistDialog"></PlaylistUpdate>
        <PlaylistDelete :confirmClose="closeDeleteDialog" :visible="deleteDialog" :id="playlist.id" @update="closeDeleteDialog"></PlaylistDelete>
    </div>
</template>