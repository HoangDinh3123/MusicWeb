<script setup>
    const authStore = useAuthStore();
    const songStore = useSongStore();

    const user = ref('');
    const listSong = computed(() => songStore.getListLikedSong);

    onMounted(async () => {
        if(authStore.getLogged) {
            await authStore.getInfo();
            user.value = authStore.getUserData;

            if(listSong.value.length == 0) {
                await songStore.getLikedSong(user.value.id);
            }
        }
    });
</script>

<template>
    <div class="sticky top-0 lg:border-l lg:mt-[10px] lg:h-screen">
        <h6 class="text-[#7a7a7a] pl-[10px] font-semibold">{{ listSong.length }} Thích</h6>

        <div
            v-for="item in listSong"  
            :key="item"
            class="h-[64px]">
            <SongHorizon 
                :song="item"
                :user="item.user"
                :isPlayButton="false" 
                :isInteraction="false"
            ></SongHorizon>
        </div>
    </div>
</template>