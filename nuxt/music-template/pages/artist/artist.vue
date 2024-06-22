<script setup>
    import {genres} from '~/data/BasicComponents.ts';

    const authStore = useAuthStore();
    const loadingStore = useLoadingStore();

    const isLoading = computed(() => loadingStore.getIsLoading);

    const artists = ref([]);
    onMounted(async () => {
        loadingStore.setLoading(true);
        try{
            artists.value = await authStore.getArtist();
        } catch (error) {
            console.error('Error fetching songs:', error);
        } finally {
            loadingStore.setLoading(false);
        }
    });

    // const isGenreList = ref(false);
    const currentGenre = ref(genres[0]);

    const changeGenre = (index) => {
        currentGenre.value = genres[index];
    }
</script>

<template>
    <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-4">
        <Loading v-if="isLoading" />
        <div class="col-span-9">
                <div class="mb-4">
                    <h2 class="font-bold text-[35px]">Danh sách nghệ sĩ</h2>
                </div>
                
                <div class="grid grid-cols-3 lg:grid-cols-4 gap-4">
                    <ArtistItem
                        v-for="artist in artists"
                        :key="artist"
                        :artist="artist"
                    >
                    </ArtistItem>
                </div>
        </div>

        <div class="col-span-3 mt-8 lg:m-0">
            <LayoutsDefaultLikedList></LayoutsDefaultLikedList>
        </div>
    </div>
</template>