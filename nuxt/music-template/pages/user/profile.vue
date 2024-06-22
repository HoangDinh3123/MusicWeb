<script setup>
    import {profileTab, genres} from '~/data/BasicComponents.ts';

    const authStore = useAuthStore();
    const songStore = useSongStore();
    const playlistStore = usePlaylistStore();
    const albumStore = useAlbumStore();
    const loadingStore = useLoadingStore();
    const alertStore = useAlertStore();

    const detailUser = ref(null);
    const userSong = ref([]);
    const listLikedSong = computed(() => songStore.getListLikedSong);

    const isLoading = computed(() => loadingStore.getIsLoading);

    onMounted(async () => {
        loadingStore.setLoading(true);
        try{
            detailUser.value = authStore.currentUser;

            await songStore.getSongByUser(detailUser.value.id);
            userSong.value = await songStore.getListUserSong;
            
            await playlistStore.getAllPlaylist(detailUser.value.id);

            await albumStore.getAllAlbum(detailUser.value.id);
        } catch (error) {
            console.error('Error fetching songs:', error);
        } finally {
            loadingStore.setLoading(false);
        }
    });

    const listPlaylist = computed(() => playlistStore.getListPlaylist);
    const listAlbum = computed(() => albumStore.getListAlbum);

    const isDescription = ref(true);
    const currentTab = ref(profileTab[0]);
    const addDialog = ref(false);
    const addPlaylistDialog = ref(false);
    const addAlbumDialog = ref(false);

    const gender = computed(() => detailUser.value.gender);
    const address = computed(() => detailUser.value.address);
    const social = computed(() => detailUser.value.social_network);
    const description = computed(() => detailUser.value.description);
    const image = ref(null);
    
    watch(() => songStore.getListUserSong, (newSong) => {
        userSong.value = newSong;
    });

    const handleFileChange = (event) => {
        const files = event.target.files;
        if (files.length > 0) {
            image.value = files[0];
        }
    };

    const updateInfo = () => {
        const updateData = {
            id: detailUser.value.id,
            gender: gender.value,
            address: address.value,
            social_network: social.value,
            description: description.value,
        };

        if (image.value) {
            updateData.image = image.value;
        }

        authStore.upadateInfo({updateData})
        .then(() => {
            alertStore.successAlert('Đã cập nhật thông tin thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }

    const handleSongUpdate = async () => {
        addDialog.value = false;
    };

    const openAddDialog = () => {
        addDialog.value = true;
    }

    const closeAddDialog = () => {
        addDialog.value = false;
    }

    const openAddPlaylistDialog = () => {
        addPlaylistDialog.value = true;
    }

    const closeAddPlaylistDialog = () => {
        addPlaylistDialog.value = false;
    }

    const openAddAlbumDialog = () => {
        addAlbumDialog.value = true;
    }

    const closeAddAlbumDialog = () => {
        addAlbumDialog.value = false;
    }

    const changeTab = (index) => {
        currentTab.value = profileTab[index];
    }

</script>

<template>
    <div class="mb-[80px]">
        <Loading v-if="isLoading" />
        <div class="flex md:flex-row flex-col pb-6 border-b">
            <div class="">
                <img 
                    :src="detailUser?.image" 
                    class="w-[180px] h-[184px] m-auto rounded-full"
                >
            </div>

            <div class="flex-1 pl-6">
                <div class="mb-2">
                    <h1 class="text-[40px] font-bold">{{ detailUser?.name }}</h1>
                </div>

                <div @click="isDescription = !isDescription" class="mb-4">
                    <p 
                        :class="{'line-clamp-1' : isDescription}" 
                        class="text-[#818a91] text-[14px]"
                    >
                        {{detailUser?.description}}
                    </p>
                </div>

                <div class="flex items-center text-[14px]">
                    <div 
                        @click="openAddDialog"
                        class="px-[16.8px] py-[5.512px] bg-[#02b875] mr-2 text-white cursor-pointer rounded-[500px]">
                        Tải nhạc
                    </div>
                    <div 
                        @click="changeTab(3)" 
                        class="px-[16.8px] py-[5.512px] bg-[#eeeeee] mr-2 cursor-pointer rounded-[500px]">
                        Sửa thông tin
                    </div>
                </div>

                <div class="flex justify-between my-4">
                    <span class="text-[14px] flex items-center">{{ listAlbum.length }} Albums, {{ userSong.length }} Tracks</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-4">
            <div class="col-span-9 mt-[10px]">
                <div class="mb-6">
                    <ul class="h-7 text-[14px] flex items-center">
                        <li 
                            v-for="(item,index) in profileTab"
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
                     <!-- Tracks -->
                     <div v-if="currentTab.name == 'Tracks'" class="mb-[50px]">
                        <div
                            v-for="(item, index) in userSong"
                            :key="index" 
                            class="h-[144px]">
                            <SongProfile :song="item"></SongProfile>
                        </div>
                    </div>
                    <!--End tracks -->

                    <!-- Albums -->
                    <div v-if="currentTab.name == 'Albums'">
                        <div class="grid grid-cols-3 lg:grid-cols-4 gap-4">
                            <div
                                @click="openAddAlbumDialog"
                                class="border rounded-md flex items-center justify-center min-h-[200px] cursor-pointer"
                            >
                                <div class="flex justify-center flex-col">
                                    <Icon name="i-mdi:plus-circle" color="black" class="w-[50px] h-[50px] m-auto mb-2"/>
                                    <p>Tạo album Mới</p>
                                </div>
                            </div>
                            <!-- <PlaylistItem 
                                v-for="item in listPlaylist"
                                :key="item"
                                :playlist="item">
                            </PlaylistItem> -->
                            <AlbumItem
                                v-for="item in listAlbum"
                                :key="item"    
                                :album="item"
                            ></AlbumItem>
                        </div>
                    </div>
                    <!--End Albums -->

                    <!-- PlayLists -->
                    <div v-if="currentTab.name == 'Playlists'">
                        <div class="grid grid-cols-3 lg:grid-cols-4 gap-4">
                            <div
                                @click="openAddPlaylistDialog"
                                class="border rounded-md flex items-center justify-center min-h-[200px] cursor-pointer"
                            >
                                <div class="flex justify-center flex-col">
                                    <Icon name="i-mdi:plus-circle" color="black" class="w-[50px] h-[50px] m-auto mb-2"/>
                                    <p>Tạo Playlist Mới</p>
                                </div>
                            </div>
                            <PlaylistItem 
                                v-for="item in listPlaylist"
                                :key="item"
                                :playlist="item">
                            </PlaylistItem>
                        </div>
                    </div>
                    <!--End PlayLists -->

                    <!-- Likes -->
                    <div v-if="currentTab.name == 'Likes'">
                        <div class="grid grid-cols-3 lg:grid-cols-4 gap-4">
                            <SongItem
                                v-for="item in listLikedSong"
                                :key="item"
                                :song="item"
                                :user="item.user" 
                                :isTop="false" 
                                :isInteraction="true"></SongItem>
                        </div>
                    </div>
                    <!--End Likes -->

                    <!-- Profile -->
                    <div v-if="currentTab.name == 'Profile'">
                        <form @submit.prevent="updateInfo" enctype="multipart/form-data">
                            <div class="md:flex mb-2 text-[14px]">
                                <h3 class="w-[300px] text-[#818a91]">Giới tính</h3>
                                <div class="flex">
                                    <div class="flex">
                                        <input v-model="detailUser.gender" value="1" id="male" name="gender" type="radio">
                                        <label for="male" class="ml-2">Nam</label>
                                    </div>

                                    <div class="flex ml-4">
                                        <input v-model="detailUser.gender" value="2" id="female" name="gender" type="radio">
                                        <label for="female" class="ml-2">Nữ</label>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-2 text-[14px] md:flex">
                                <span class="w-[300px] text-[#818a91] flex items-center">Địa chỉ</span>
                                <div class="flex-1 border">
                                    <input 
                                        type="text" 
                                        class="w-full p-2 focus:outline-none" 
                                        v-model="detailUser.address" 
                                    >
                                </div>
                            </div>

                            <div class="mb-2 text-[14px] md:flex">
                                <span class="w-[300px] text-[#818a91] flex items-center">Mạng xã hội</span>
                                <div class="flex-1 border">
                                    <input 
                                        type="text" 
                                        class="w-full p-2 focus:outline-none" 
                                        placeholder="http://"
                                        v-model="detailUser.social_network"
                                    >
                                </div>
                            </div>

                            <div class="mb-2 text-[14px] md:flex">
                                <span class="w-[300px] text-[#818a91] flex items-center">Mô tả</span>
                                <div class="flex-1 border">
                                    <textarea 
                                        class="w-full h-full p-2 focus:outline-none" 
                                        v-model="detailUser.description">
                                    </textarea>
                                </div>
                            </div>

                            <div class="mb-2 text-[14px] md:flex">
                                <span class="w-[300px] text-[#818a91] flex items-center">Thay đổi ảnh đại diện</span>
                                <div class="flex-1 border">
                                    <input type="file" accept="image/*" @change="handleFileChange">
                                </div>
                            </div>

                            <button class="px-[20px] py-[20px] bg-slate-200 rounded-lg mt-[20px]">Sửa thông tin</button>
                        </form>
                    </div>
                    <!--End Profile -->
                </div>
            </div>

            <div class="col-span-3 mt-8 lg:m-0">
                <LayoutsDefaultLikedList></LayoutsDefaultLikedList>
            </div>
        </div>

        <SongAddOrUpdate :confirmClose="closeAddDialog" :visible="addDialog" @update="handleSongUpdate"></SongAddOrUpdate>

        <AlbumUpdate :confirmClose="closeAddAlbumDialog" :visible="addAlbumDialog" @update="closeAddAlbumDialog"></AlbumUpdate>

        <PlaylistUpdate :confirmClose="closeAddPlaylistDialog" :visible="addPlaylistDialog" @update="closeAddPlaylistDialog"></PlaylistUpdate>
    </div>
</template>