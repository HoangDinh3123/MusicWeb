<script setup>

    definePageMeta({
        layout: 'admin',
        middleware: 'admin'
    });
    
    const genreStore = useGenreStore();
    const alertStore = useAlertStore();
    const loadingStore = useLoadingStore();
    const isLoading = computed(() => loadingStore.getIsLoading);

    const listGenre = computed(() => genreStore.getListGenre);

    const name = ref(null);

    const deleteDialog = ref(false);
    const seletedGenre = ref(null);
    const selectedId = ref(null);

    onMounted(async () => {
        loadingStore.setLoading(true);
        try{
            await genreStore.getAllGenre();
        } catch (error) {
            console.error('Error fetching songs:', error);
        } finally {
            loadingStore.setLoading(false);
        }
    });

    const add = () => {
        genreStore.addGenre({
            name: name.value
        })
        .then(() => {
            alertStore.successAlert('Đã cập nhật thông tin thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }

    const selectDelete = (item) => {
        name.value = item.name;
        selectedId.value = item.id;
    }
    
    const edit = () => {
        genreStore.editGenre(selectedId.value,{
            name: name.value
        })
        .then(() => {
            selectedId.value = null;
            alertStore.successAlert('Đã cập nhật thể loại thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }

    const openDeleteDialog = (selectedId) => {
        seletedGenre.value = selectedId;
        deleteDialog.value = true;
    }

    const closeDeleteDialog = () => {
        seletedGenre.value = null;
        deleteDialog.value = false;
    }

</script>

<template>
    <div>
        <Loading v-if="isLoading" />
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-5 h-[200px] p-[10px] bg-white">
                <h3 class="text-[20px] font-bold mb-[20px]">Thêm thể loại</h3>
                <form @submit.prevent="selectedId !== null ? edit() : add()">
                    <div class="flex items-center mb-[20px]">
                        <label for="name" class="mr-[20px]">Tên thể loại</label>
                        <input 
                            v-model="name"
                            @change="v$.name.$touch"
                            id="name" 
                            type="text" 
                            class="flex-1 border focus:outline-none px-[10px] py-[5px] rounded-md">
                    </div>

                    <button class="px-[10px] py-[5px] bg-slate-400 rounded-md">
                        Xác nhận
                    </button>
                </form>
            </div>

            <table class="w-full whitespace-no-wrap col-span-7">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        <th class="px-4 py-3"></th>
                        <th class="px-4 py-3">Tên thể loại</th>
                        <th class="px-4 py-3">Ngày tạo</th>
                        <th class="px-4 py-3">Ngày cập nhật</th>
                        <th class="px-4 py-3 text-center">Actions</th>
                    </tr>
                </thead>
                
                <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                >
                    <tr 
                        v-for="(item, index) in listGenre"
                        :key="item"
                        class="text-gray-700 dark:text-gray-400">

                        <td class="px-4 py-3 text-sm">
                            {{ index + 1 }}
                        </td>

                        <td class="px-4 py-3 text-sm">
                            {{ item.name}}
                        </td>

                        <td class="px-4 py-3 text-sm">
                            {{ formatDate(item.created_at) }}
                        </td>

                        <td class="px-4 py-3 text-sm">
                            {{ formatDate(item.updated_at) }}
                        </td>

                        <td class="px-4 py-3 flex justify-center">
                            <div class="text-sm">
                                <button
                                    @click="selectDelete(item)"
                                    class=" px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Delete"
                                >
                                    <Icon name="i-ic:baseline-remove-red-eye" color="blue" class="w-[24px] h-[24px]"/>
                                </button>
                            </div>

                            <div class="text-sm">
                                <button
                                    @click="openDeleteDialog(item.id)"
                                    class=" px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                                    aria-label="Delete"
                                >
                                    <Icon name="i-ic:baseline-delete" color="blue" class="w-[24px] h-[24px]"/>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        <GenreDelete :id="seletedGenre" :visible="deleteDialog" :confirmClose="closeDeleteDialog" @update="closeDeleteDialog"></GenreDelete>
    </div>
</template>