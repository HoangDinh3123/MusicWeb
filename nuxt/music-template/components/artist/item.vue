<script setup>
    const props = defineProps({
        artist: {
            type: Object,
            default: () => ({})
        },
    });

</script>

<template>
    <div >
        <NuxtLink
                :to="'/artist/' + artist.id"
                class="rounded-full block"
        >
            <div class="relative w-full after:block after:pt-[100%]">
                <img 
                    id="avatar" 
                    class="absolute top-0 left-0 w-full h-full rounded-full bg-cover" 
                    :src="artist.image ? artist.image : 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Ladies%27_Code_on_May_24%2C_2013.jpg'" 
                    alt="avatar">
            </div>
        </NuxtLink>

        <div class="mt-[10px] mb-[20px] text-center">
            <NuxtLink 
                :to="'/artist/' + artist.id"
                class="block text-[14px]"
            >{{ artist.name }}</NuxtLink>
            <p class="text-[12.8px] text-[#818a91]">{{ artist.songs_count }} bài hát</p>
        </div>
    </div>
</template>
