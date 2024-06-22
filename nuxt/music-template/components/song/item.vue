<script setup>
    const songStore = useSongStore();

    const iconColor = ref('white');
    const isSelected = ref(false);

    const props = defineProps({
        song: {
            type: Object,
            default: () => ({}) // Mặc định là một đối tượng trống nếu không có dữ liệu bài hát được truyền vào
        },
        user: {
            type: Object,
            default: () => ({})
        },
        isTop: {
            type: Boolean,
            default: true
        },
        isInteraction: {
            type: Boolean,
            default: false
        }
    })

    const changeSong = (id) => {
        songStore.setCurrentSong(id);
    }

    const changeColor = (color) => {
        iconColor.value = color;
    }
    const resetColor = () => {
        iconColor.value = 'white';
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
                :src="song.image" 
                alt=""
                class="absolute top-0 left-0 w-full h-full bg-cover rounded-sm"
            >

            <div 
                @click="changeSong(song.id)"
                @mouseover="changeColor(black)"
                @mouseleave="resetColor"
                :class="{'opacity-100': isSelected}"
                class="opacity-0 absolute z-10 flex justify-center items-center top-1/2 left-1/2 -mt-[20px] -ml-[20px] w-10 h-10 cursor-pointer border-2 rounded-full hover:bg-white transition ease-out"
            >
                <Icon name="i-mdi:play" :color="iconColor" class="w-[35px] h-[35px]"/>
            </div>

            <div class="absolute w-full h-full top-0 px-[20px] py-[15px]">
                <div v-if="isTop">
                    <NuxtLink :to="'/song/' + song.id " class="text-[18px] leading-6 text-white font-bold">{{song.name}}</NuxtLink>
                </div>
                <div v-if="isTop">
                    <NuxtLink to="/" class="text-[12.8px] leading-6 text-[#7a7a7a] transition-all hover:text-[#b0b0b0]">{{ user.name }}</NuxtLink>
                </div>

                <SongAction 
                    v-if="isSelected" 
                    :id="song.id"
                    :isLike="song.liked_by_user"
                    class="z-20 p-2 absolute bottom-0 right-0 left-0">
                </SongAction>

                <div :class="{'opacity-100': isSelected}" class="opacity-0 h-10 absolute bottom-0 right-0 left-0 bg-gradient-to-t from-black ease-out transition-all rounded-sm"></div>
            </div>
        </div>

        <div v-if="!isTop" class="w-full pt-[10px]">
            <NuxtLink :to="'/song/' + song.id"  class="text-black text-[14px] line-clamp-1 block">{{ song.name }}</NuxtLink>
            <NuxtLink 
                v-if="!isInteraction"
                :to="'/artist/' + user.id"
                class="text-[#d0d0d0] text-[12.8px] block"
            >
                {{ user.name }}
            </NuxtLink>
            <SongInteraction 
                v-if="isInteraction"
                    :sum_like="song?.total_likes" 
                    :sum_play="song?.total_play_count"
                ></SongInteraction>
        </div>
    </div>
</template>