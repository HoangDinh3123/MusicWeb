<script setup>
    import {genres} from '~/data/BasicComponents.ts';

    const genreStore = useGenreStore();
    const songStore = useSongStore();
    const loadingStore = useLoadingStore();
    
    const listSong = ref(null);
    const listGenre = ref([]);
    const currentGenre = ref(null);

    const isGenreList = ref(false);
    const all = ref(
        {
            id: 0,
            name: 'All'
        });

    const isLoading = computed(() => loadingStore.getIsLoading);

    onMounted(async () => {
        loadingStore.setLoading(true);
        try{
            listSong.value = await songStore.getAllSong();
            listGenre.value = await genreStore.getAllGenre();

            listGenre.value.unshift(all.value);

            currentGenre.value = listGenre.value[0];
        } catch (error) {
            console.error('Error fetching songs:', error);
        } finally {
            loadingStore.setLoading(false);
        }
    });

    const changeGenre = async (id) => {
        const index = listGenre.value.findIndex(item => item.id === id);
        currentGenre.value = listGenre.value[index];

        if(currentGenre.value.id == 0) {
            getAll();
        } else {
            const detailGenre = await genreStore.getDetailGenre(id);
            listSong.value = detailGenre.songs;
        }
    }

    const getAll = async () => {
        listSong.value = await songStore.getAllSong();
    }
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-4">
        <Loading v-if="isLoading" />
        <div class="col-span-9">
                <div class="flex items-center mb-4">
                    <h2 class="font-bold text-[40px]">Mới</h2>

                    <div 
                        @click="isGenreList = !isGenreList"
                        class="py-[6px] px-3 ml-2 relative flex items-center hover:bg-[#f1f1f1] rounded-md cursor-pointer"
                    >
                        <span>{{currentGenre?.name}}</span>
                        <Icon name="i-mdi:menu-down" color="#02b875" class="w-7 h-7"></Icon>

                        <div v-if="isGenreList" class="absolute top-full left-0 mt-[2px] w-[160px] py-[5px] z-20 bg-white border rounded-sm">
                            <button
                                v-for="item in listGenre"
                                :key="item"
                                @click="changeGenre(item.id)"
                                :class="{'active': currentGenre?.id == item.id}"
                                class="w-full px-5 py-[3px] text-[14px] [&.active]:bg-[#eee] hover:bg-[#eee]">
                                {{item.name}}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-3 lg:grid-cols-4 gap-4">
                    <SongItem 
                        v-for="song in listSong"
                        :key="song"
                        :song="song"
                        :user="song.user"
                        :isTop="false"
                    >
                    </SongItem>
                </div>
        </div>

        <div class="col-span-3 mt-8 lg:m-0">
            <LayoutsDefaultLikedList></LayoutsDefaultLikedList>
        </div>
    </div>
</template>