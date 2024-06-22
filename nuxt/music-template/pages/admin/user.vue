<script setup>

    definePageMeta({
        layout: 'admin',
        middleware: 'admin'
    })

    const authStore = useAuthStore();
    const loadingStore = useLoadingStore();
    const isLoading = computed(() => loadingStore.getIsLoading);

    const currentPage = ref(1);
    const itemsPerPage = ref(5);
    const listUser = ref([]);
    const songs = ref([]);
    const isDialog = ref(false);

    const displayedItems = computed(() => {
      const startIndex = (currentPage.value - 1) * itemsPerPage.value;
      const endIndex = startIndex + itemsPerPage.value;
      return listUser.value.slice(startIndex, endIndex);
    });

    const totalPages = computed(() => Math.ceil(listUser.value.length / itemsPerPage.value));

    onMounted(async () => {
        loadingStore.setLoading(true);
        try{
            listUser.value = await authStore.getListUser();

        } catch (error) {
            console.error('Error fetching songs:', error);
        } finally {
            loadingStore.setLoading(false);
        }
    });

    const changePage = (offset) => {
      currentPage.value += offset;
    };

    const selectPage = (pageNumber) => {
      currentPage.value = pageNumber;
    };

    const openDialog = (listSong) => {
        songs.value = listSong;
        isDialog.value = true;
    }

    const closeDialog = () => {
        songs.value = [];
        isDialog.value = false;
    }
</script>

<template>
    <div>
        <table class="w-full whitespace-no-wrap">
            <thead>
                <tr
                    class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                >
                    <th class="px-4 py-3">Người dùng</th>
                    <th class="px-4 py-3">Giới tính</th>
                    <th class="px-4 py-3">Vai trò</th>
                    <th class="px-4 py-3">Album</th>
                    <th class="px-4 py-3">Trạng thái</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            
            <tbody
                class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
                <tr 
                    v-for="item in displayedItems"
                    :key="item"
                    class="text-gray-700 dark:text-gray-400">
                    <td class="px-4 py-3">
                        <div class="flex items-center text-sm">
                            <!-- Avatar with inset shadow -->
                            <div
                            class="relative hidden w-8 h-8 mr-3 rounded-full md:block"
                            >
                            <img
                                class="object-cover w-full h-full rounded-full"
                                :src="item.image ? item.image : 'https://images.unsplash.com/flagged/photo-1570612861542-284f4c12e75f?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=200&fit=max&ixid=eyJhcHBfaWQiOjE3Nzg0fQ'"
                                alt=""
                                loading="lazy"
                            />
                            <div
                                class="absolute inset-0 rounded-full shadow-inner"
                                aria-hidden="true"
                            ></div>
                            </div>
                            <div>
                            <p class="font-semibold">{{ item.name }}</p>
                            <p class="text-xs text-gray-600 dark:text-gray-400">
                                {{ item.songs.length }} bài hát
                            </p>
                            </div>
                        </div>
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ item.gender == 1 ? 'Nam' : 'Nữ' }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ item.songs.length > 0 ? 'Nghệ sĩ' : 'Người dùng' }}
                    </td>

                    <td class="px-4 py-3 text-sm">
                        {{ item.albums.length }} album
                    </td>

                    <td class="px-4 py-3 text-xs">
                        <span
                            class="px-2 py-1 font-semibold leading-tight text-green-700 bg-green-100 rounded-full dark:bg-green-700 dark:text-green-100"
                        >
                            {{ item.songs.length >= 5 ? 'Nổi bật' : 'Bình thường' }}
                        </span>
                    </td>

                    <td class="px-4 py-3 flex justify-center">
                        <div class="text-sm">
                            <button
                                @click="openDialog(item.songs)"
                                class=" px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                aria-label="Delete"
                            >
                                <Icon name="i-ic:baseline-remove-red-eye" color="blue" class="w-[24px] h-[24px]"/>
                            </button>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="mt-[20px] flex justify-center text-black text-[12px]">
            <button 
                @click="changePage(-1)"
                :class="{'hidden': currentPage === 1}"
                class="w-[24px] h-[24px] rounded-md flex items-center justify-center border border-[#00000066]">
                <Icon name="i-ic:baseline-keyboard-arrow-left" color="black" class="w-[20px] h-[20px]"/>
            </button>

            <div
                v-for="index in totalPages"
                :key="index"
                :class="{'selected': currentPage === index}"
                @click="selectPage(index)"
                class="w-[24px] h-[24px] ml-[5px] [&.selected]:bg-[#008000] [&.selected]:text-white rounded-md flex items-center justify-center border border-[#00000066] cursor-pointer"
                >
                {{ index }}
            </div>

            <button 
                @click="changePage(1)" 
                :class="{'hidden': currentPage === totalPages}"
                class="w-[24px] h-[24px] ml-[5px] rounded-md flex items-center justify-center border border-[#00000066]">
                <Icon name="i-ic:baseline-keyboard-arrow-right" color="black" class="w-[20px] h-[20px]"/>
            </button>
        </div>

        <AdminListSongDialog :songs="songs" :visible="isDialog" :confirmClose="closeDialog"></AdminListSongDialog>
    </div>
</template>