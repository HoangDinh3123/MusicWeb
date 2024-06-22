<script setup>
import { ref } from "vue";

    const props = defineProps({
        isVisible: {
            type: Boolean,
            default: false
        },
        close: {
            type: Function,
        },
    })

    const songStore = useSongStore();

    const listSong = ref([]);
    const keyword = ref('');
    const oldKey = ref('');

    const search = async () => {
        listSong.value = await songStore.search({
            keyword: keyword.value
        });

        oldKey.value = keyword.value;
        console.log(listSong.value);
    } 
</script>

<template>
    <div :class="{'z-[1000]': isVisible}" v-if="isVisible" class="fixed w-full h-full bg-white transition-all ease-in-out delay-75">
        <div class="relative">
            <div
                @click="close" 
                class="absolute top-0 right-0 cursor-pointer">
                <span class="block pr-4 text-[20px] text-[#818a91]">x</span>
            </div>
        </div>

        <div class="p-12">
            <div class="lg:w-[70%] lg:m-auto">
                <form @submit.prevent="search" class="mb-6">
                    <div class="flex">
                        <input 
                            v-model="keyword"
                            type="text" 
                            placeholder="Từ khóa..." 
                            class="flex-1 py-3 border focus:outline-none rounded-l-md px-2"
                        >
                        <button class="border rounded-r-md px-2">
                            <span class="block">Tìm kiếm</span>
                        </button>
                    </div>
                </form>

                <div v-if="listSong.length> 0">
                    <div class="mb-6">
                        <p class="text-[14px] text-[#818a91]">
                            <span class="text-black">{{ listSong.length }}</span>
                            Kết quả cho:
                            <span class="text-black">{{ oldKey }}</span>
                        </p>
                    </div>

                    <div class="grid grid-cols-2">
                        <div class="col-span-1">
                            <div
                                v-for="song in listSong"
                                :key="song" 
                                class="h-[84px]">
                                <SongHorizon 
                                    :song="song"
                                    :isInteraction="false"
                                >
                                </SongHorizon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>