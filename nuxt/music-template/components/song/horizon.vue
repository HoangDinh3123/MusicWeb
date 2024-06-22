<script setup>
    const songStore = useSongStore();

    const iconColor = ref('white');
    const isSelected = ref(false);

    const props = defineProps({
        order: {
            type: [String , Number],
            default: null
        },
        song: {
            type: Object,
            default: () => ({})
        },
        user: {
            type: Object,
            default: () => ({})
        },
        isPlayButton: {
            type: Boolean,
            default: true
        },
        isInteraction: {
            type: Boolean,
            default: true
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
            @mouseover="isSelected = true "
            @mouseleave="isSelected = false"
            class="block w-full h-full border-b hover:bg-[#f1f1f1]"
        >
            <div class="px-[10px] py-3 h-full">
                <div class="flex items-center h-full">
                    <span v-if="order !== null" class="ml-[10px] mr-[20px] text-[#7a7a7a]">
                        {{ order + 1}}
                    </span>
                    
                    <div class="h-full flex flex-1">
                        <div
                            :style="{ 'background-image': `url(${song.image})` }"
                            :class="{ 'min-w-[60px]': isPlayButton, 'min-w-10': !isPlayButton }"
                            class="relative rounded-sm bg-cover h-full cursor-pointer bg-center bg-no-repeat object-fit"
                        >    
                            <div 
                                v-if="isPlayButton"
                                @click="changeSong(song.id)"
                                @mouseover="changeColor(black)"
                                @mouseleave="resetColor"
                                :class="{'opacity-100': isSelected}"
                                class="opacity-0 absolute z-50 flex justify-center items-center w-7 h-7 top-1/2 left-1/2 -mt-[15px] -ml-[15px] cursor-pointer border-2 rounded-full hover:bg-white transition ease-out">
                                <Icon name="i-mdi:play" :color="iconColor" class="w-[15px] h-[15px]"/>
                            </div>
                        </div>

                        <div class="pl-2 flex-1 flex justify-between">
                            <div class="w-3/5">
                                <NuxtLink
                                    :to="'/song/' + song.id" 
                                    class="text-[#000000DE] text-[14px] font-semibold line-clamp-1"
                                >
                                    {{song.name}}
                                </NuxtLink>
                                <NuxtLink
                                    to="/" 
                                    class="text-[#7a7a7a] text-[12.8px]"
                                >
                                    {{ song.user.name }}
                                </NuxtLink>
                            </div>

                            <div v-if="isInteraction">
                                <SongInteraction 
                                    v-if="!isSelected" 
                                    :sum_like="song.total_likes" 
                                    :sum_play="song.total_play_count">
                                </SongInteraction>
                            </div>

                            <SongAction v-if="isSelected" :icon-color="'#818a91'" :id="song.id"></SongAction>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</template>