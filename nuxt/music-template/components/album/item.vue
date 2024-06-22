<script setup>
    import authImage from '~/assets/images/auth.jpg';
    const props = defineProps({
        album: {
            type: Object,
            default: () => ({}) // Mặc định là một đối tượng trống nếu không có dữ liệu bài hát được truyền vào
        },
    })

    const isSelected = ref(false);
    const deleteDialog = ref(false);
    const updateAlbumDialog = ref(false);

    const openDeleteDialog = () => {
        deleteDialog.value = true;
    }

    const closeDeleteDialog = () => {
        deleteDialog.value = false;
    }

    const openUpdateAlbumDialog = () => {
        updateAlbumDialog.value = true;
    }

    const closeUpdateAlbumDialog = () => {
        updateAlbumDialog.value = false;
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
                :src="album.image"
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
                    @click="openUpdateAlbumDialog"
                    class="cursor-pointer">
                    <Icon name="i-mdi:circle-edit-outline" color="#d0d0d0" class="w-[30px] h-[30px] md:w-[35px] md:h-[35px]"/>
                </div>
                
            </div>
        </div>

        <div class="w-full pt-[10px]">
            <NuxtLink :to="'/album/' + album.id" class="text-black text-[14px] line-clamp-1 block">{{ album.name }}</NuxtLink>
            <div 
                class="text-[#d0d0d0] text-[12.8px] block"
            >
                {{ album.songs.length }} bài hát
            </div>
        </div>

        <AlbumUpdate :confirmClose="closeUpdateAlbumDialog" :visible="updateAlbumDialog" :album="album" @update="closeUpdateAlbumDialog"></AlbumUpdate>
        <AlbumDelete :confirmClose="closeDeleteDialog" :visible="deleteDialog" :id="album.id" @update="closeDeleteDialog"></AlbumDelete>
    </div>
</template>