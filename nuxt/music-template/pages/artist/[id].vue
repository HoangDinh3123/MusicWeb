<script setup>
    import {tab} from '~/data/BasicComponents.ts';

    const route = useRoute();

    const authStore = useAuthStore();
    const loadingStore = useLoadingStore();

    const isLoading = computed(() => loadingStore.getIsLoading);
    const artist = ref(null);

    onMounted(async () => {
        loadingStore.setLoading(true);
        try{
            artist.value = await authStore.getDetail(route.params.id);
        } catch (error) {
            console.error('Error fetching songs:', error);
        } finally {
            loadingStore.setLoading(false);
        }
    });

    const isDescription = ref(true);
    const currentTab = ref(tab[0]);

    const changeTab = (index) => {
        currentTab.value = tab[index];
    }
</script>

<template>
    <div>
        <Loading v-if="isLoading" />
        <div class="flex md:flex-row flex-col pb-6 border-b">
            <div class="">
                <img 
                    :src="artist?.image ? artist?.image : 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Ladies%27_Code_on_May_24%2C_2013.jpg'" 
                    alt="avatar" 
                    class="w-[180px] h-[184px] m-auto rounded-full"
                >
            </div>

            <div class="flex-1 pl-6">
                <div class="mb-2">
                    <h1 class="text-[40px] font-bold">{{ artist?.name }}</h1>
                </div>

                <div @click="isDescription = !isDescription" class="mb-4">
                    <p 
                        :class="{'line-clamp-1' : isDescription}" 
                        class="text-[#818a91] text-[14px]"
                    >
                        {{ artist?.description }}
                    </p>
                </div>

                <div class="flex justify-between mb-4">
                    <span class="text-[14px] flex items-center">{{ artist?.albums.length }} Albums, {{ artist?.songs.length }} Bài hát</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-4">
            <div class="col-span-9 mt-[10px]">
                <div class="mb-6">
                    <ul class="h-7 text-[14px] flex items-center">
                        <li 
                            v-for="(item,index) in tab"
                            :key="item"
                            class="mr-4 cursor-pointer"
                        >
                            <div 
                                @click="changeTab(index)"
                                :class="{'before:w-full': currentTab.name == item.name}"
                                class="relative before:content-[''] before:absolute before:bottom-0 before:left-0 before:w-0 before:h-[2px] before:bg-[#02b875] duration-300 hover:before:w-full before:transition-all"
                            >
                                {{ item.name }}
                            </div>
                        </li>
                    </ul>
                </div>

                <div>
                    <!-- Overview -->
                    <div v-if="currentTab.name == 'Bài hát'" class="mb-[50px]">
                        <h5 class="text-[20px] font-bold mb-4">Bài hát</h5>

                        <div class="lg:grid lg:grid-cols-2 gap-4    ">
                            <div
                                v-for="(song, index) in artist?.songs"
                                :key="song" 
                                class="h-[84px]">
                                <SongHorizon 
                                    :order="index"
                                    :song="song"
                                    class="h-[84px]" :id="'1'"
                                >
                                </SongHorizon>
                            </div>

                        </div>
                    </div>
                    <!--End Overview -->

                    <!-- Profile -->
                    <div v-if="currentTab.name == 'Thông tin'">
                        <div class="mb-2 text-[14px] flex">
                            <span class="w-[90px] text-[#818a91]">Giới tính</span>
                            <span class="flex-1">{{ artist?.gender == 1 ? 'Nam' : 'Nữ' }}</span>
                        </div>

                        <div class="mb-2 text-[14px] flex">
                            <span class="w-[90px] text-[#818a91]">Địa chỉ</span>
                            <span class="flex-1">{{ artist?.address }}</span>
                        </div>

                        <div class="mb-2 text-[14px] flex">
                            <span class="w-[90px] text-[#818a91]">Mạng xã hội</span>
                            <NuxtLink :to="artist?.social_network" class="flex-1 text-[#ff6347]">{{ artist?.social_network }}</NuxtLink>
                        </div>
                    </div>
                    <!--End Profile -->
                </div>

                
            </div>

            <div class="col-span-3 mt-8 lg:m-0">
                <LayoutsDefaultLikedList></LayoutsDefaultLikedList>
            </div>
        </div>
    </div>
</template>