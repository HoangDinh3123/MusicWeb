<script setup>
    const route = useRoute();
    const { $pusher } = useNuxtApp();

    const songStore = useSongStore();
    const albumStore = useAlbumStore();
    const authStore = useAuthStore();
    const commentStore = useCommentStore();
    const loadingStore = useLoadingStore();

    const isLoading = computed(() => loadingStore.getIsLoading);

    const detailSong = ref(null);
    const song = ref(null);
    const artist = ref(null);
    const comments = ref(null);
    const detailAlbum = ref(null);

    const isDescription = ref(true);
    const iconColor = ref('#31c38d');
    const isMenu = ref(false);

    const content = ref('');

    onMounted(async () => {
        loadingStore.setLoading(true);
        try{
            detailSong.value = await songStore.getSongById(route.params.id);
            song.value = detailSong.value.song;

            artist.value = await authStore.getDetail(song.value.user.id);
            
            comments.value = detailSong.value.comments;

            if(song.value.album_id) {
                detailAlbum.value = await albumStore.getDetailAlbum(song.value.album_id.id);
            }

            const channel = $pusher.subscribe('comment-' + song.value.id);
            channel.bind('post', (data, songId) => {
                comments.value.push(data.data);
            });
        } catch (error) {
            console.error('Error fetching songs:', error);
        } finally {
            loadingStore.setLoading(false);
        }
    });

    const addComment = () => {
        commentStore.addComment({
            user_id: authStore.currentUser.id,
            song_id: song.value.id,
            content: content.value
        });
    }

    const openMenu= () => {
        isMenu.value = !isMenu.value;
    }

    const changeColor = (color) => {
        iconColor.value = color;
    }
    const resetColor = () => {
        iconColor.value = '#31c38d';
    }
</script>

<template>
    <div>
        <Loading v-if="isLoading" />
        <div class="flex md:flex-row flex-col pb-6 border-b">
            <div class="">
                <img 
                    :src="song?.image" 
                    alt="~/assets/images/lactroi.jpg" 
                    class="w-[180px] h-[184px] m-auto rounded-md"
                >
            </div>

            <div class="flex-1 pl-6">
                <div class="mb-2">
                    <h1 class="text-[40px] font-bold">{{ song?.name }}</h1>
                </div>

                <div @click="isDescription = !isDescription" class="mb-4">
                    <div
                        :class="{'line-clamp-1' : isDescription}" 
                        class="text-[#818a91] text-[14px]"
                        v-html="song?.description">
                    </div>
                </div>

                <div class="flex justify-between mb-4">
                    <div class="flex items-center">
                        <div 
                            @mouseover="changeColor('black')"
                            @mouseleave="resetColor"
                            class="flex justify-center items-center mr-2 w-10 h-10 cursor-pointer border-2 rounded-full hover:bg-[#31c38d] hover:border-none duration-300 transition ease-out"
                        >
                            <Icon name="i-mdi:play" :color="iconColor" class="w-[35px] h-[35px]"/>
                        </div>

                        <span class="text-[14px] text-[#a5a7a8]"> {{ song?.total_play_count }} </span>

                        <div class="flex items-center">
                            <div class="w-9 h-9 ml-2 flex justify-center items-center cursor-pointer rounded-full hover:bg-[#e1e2e2]">
                                <Icon name="i-ic:twotone-favorite-border" color="black" class="w-[20px] h-[20px]"/>
                            </div>

                            <span class="text-[14px] text-[#a5a7a8] ml-1">{{ song?.total_likes }}</span>
                        </div>

                        <div
                            @click="openMenu"
                            class="w-9 h-9 ml-2 relative flex justify-center items-center cursor-pointer rounded-full hover:bg-[#e1e2e2]"
                        >
                            <Icon name="i-mdi:dots-horizontal" color="black" class="w-[20px] h-[20px]"/>

                            <SongMenu :isOpen="isMenu" :id="song?.id"></SongMenu>
                        </div>
                    </div>


                    <div class="w-9 h-9 rounded-full bg-[#e7e7e7] flex items-center justify-center cursor-pointer">
                        <Icon name="i-ic:round-share" color="black" class="w-4 h-4"></Icon>
                    </div>
                </div>

                <div>
                    <div 
                        v-for="( genre, index ) in song?.genres"
                        :key="index"
                        class="h-[21px] px-[15px] bg-[#e7e7e7] hover:bg-white rounded-lg border mr-2 mb-2 float-left cursor-pointer">
                        <span class="m-auto block text-[12.8px]">{{ genre.name }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-4">
            <div class="col-span-9 mt-[10px]">
                <div v-if="detailAlbum" class="mb-[30px]">
                    <h6 class="text-[#7a7a7a] mb-4">
                        <span>Những bài hát cùng album </span>
                        <span class="font-[600] text-black">{{ detailAlbum?.name }}</span>
                        <span class="text-[13px]"> - {{ detailAlbum?.songs.length }} bài hát</span>
                    </h6>

                    <div 
                        v-for="(item, index) in detailAlbum?.songs.filter(item => item.id !== song?.id).slice(0, 5)"
                        :key="index"
                        class="h-[84px]"
                    >
                        <SongHorizon
                            :order="index"
                            :song="item"
                            :user="song?.user"
                            class="h-[84px]">
                        </SongHorizon>
                    </div>
                </div>

                <div v-if="artist">
                    <h6 class="text-[#7a7a7a] mb-4">
                        <span>by </span>
                        <NuxtLink :to="'/artist/' + artist?.id" class="font-[600] text-black">{{ artist?.name }}</NuxtLink>
                        <span class="text-[13px]"> - {{ artist?.songs.length }} bài hát, {{ artist?.albums.length }} album</span>
                    </h6>

                    <div 
                        v-for="(item, index) in artist?.songs.filter(item => item.id !== song?.id).slice(0, 5)"
                        :key="index"
                        class="h-[84px]"
                    >
                        <SongHorizon
                            :order="index"
                            :song="item"
                            :user="song?.user"
                            class="h-[84px]">
                        </SongHorizon>
                    </div>
                </div>

                <div class="mt-[20px]">
                    <h6 class="font-bold text-[20px] mb-4">Bình luận</h6>

                    <div>
                        <CommentItem
                            v-for="comment in comments"
                            :key="comment"
                            :comment="comment"
                            :song_id="song?.id"
                        ></CommentItem>
                    </div>
                </div>

                <div class="my-[50px]">
                    <h6 class="font-bold text-[20px] mb-4">Để lại bình luận</h6>

                    <div>
                        <h5 class="text-[14px] mb-2">Bình luận</h5>
                        <form @submit.prevent="addComment">
                            <textarea 
                                v-model="content"
                                placeholder="Type your comment" class="min-h-[100px] w-full p-5 focus:outline-none border"
                            >
                            </textarea>

                            <button class="p-2 rounded-lg text-[14px] text-white bg-slate-400">Đăng tải</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-span-3 mt-8 lg:m-0">
                <LayoutsDefaultLikedList></LayoutsDefaultLikedList>
            </div>
        </div>
    </div>
</template>