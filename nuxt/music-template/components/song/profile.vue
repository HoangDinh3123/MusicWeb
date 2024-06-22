<script setup>
    const emits = defineEmits(['songDeleted', 'songUpdated']);

    const iconColor = ref('white');
    const isSelected = ref(false);
    const deleteDialog = ref(false);
    const editDialog = ref(false);

    const props = defineProps({
        song: {
            type: Object,
            default: () => ({}) // Mặc định là một đối tượng trống nếu không có dữ liệu bài hát được truyền vào
        },
    })

    const openEditDialog = (item) => {
        editDialog.value = true;
    }

    const closeEditDialog = () => {
        editDialog.value = false;
    }

    const handleUpdate = (song) => {
        emits('songUpdated', song);
        editDialog.value = false;
    };

    const handleDelete = () => {
        emits('songDeleted', props.song.id);
        deleteDialog.value = false;
    };

    const changeColor = (color) => {
        iconColor.value = color;
    }
    const resetColor = () => {
        iconColor.value = 'white';
    }

    const openDeleteDialog = () => {
        deleteDialog.value = true;
    }

    const closeDeleteDialog = () => {
        deleteDialog.value = false;
    }

</script>

<template>
    <div class="h-full">
        <div 
            @mouseover="isSelected = true "
            @mouseleave="isSelected = false"
            class="block w-full h-full border-b hover:bg-[#f1f1f1]"
        >
            <div class="px-[10px] py-3 h-full">
                <div class="flex items-center h-full">
                    
                    <div class="h-full flex flex-1">
                        <div
                            :style="{ backgroundImage: `url(${song.image})` }"
                            class="relative rounded-sm bg-cover min-w-[120px] h-full cursor-pointer bg-center bg-no-repeat object-fit"
                        >    
                            <div 
                                @mouseover="changeColor(black)"
                                @mouseleave="resetColor"
                                :class="{'opacity-100': isSelected}"
                                class="opacity-0 absolute z-50 flex justify-center items-center w-7 h-7 top-1/2 left-1/2 -mt-[15px] -ml-[15px] cursor-pointer border-2 rounded-full hover:bg-white transition ease-out">
                                <Icon name="i-mdi:play" :color="iconColor" class="w-[15px] h-[15px]"/>
                            </div>
                        </div>

                        <div class="pl-2 flex-1 flex justify-between">
                            <div>
                                <NuxtLink
                                    :to="'/song/' + song.id" 
                                    class="text-[#000000DE] text-[14px] font-semibold line-clamp-1"
                                >
                                    {{song.name}}
                                </NuxtLink>
                                <div class="flex items-center">
                                    <NuxtLink 
                                        v-for="item in song.genres"
                                        :key="item"
                                        to="/browse"
                                        class="px-[5px] py-[2px] text-[10px] text-white bg-[#ced2d6] rounded-md mr-2">
                                        {{ item.name }}
                                    </NuxtLink>
                                    <span class="text-[10px] ml-2 text-[#b0b0b0]">{{song.created_at}}</span>
                                </div>

                                <div>
                                    <div class="mt-2 text-[12px] text-[#b0b0b0] line-clamp-2" v-html="song.description"></div>
                                </div>

                                <div class="flex mt-2">
                                    <div 
                                        @click="openEditDialog"
                                        class="px-2 py-[2.5] text-[12px] bg-white border rounded-md mr-2 hover:bg-[#f1f1f1] cursor-pointer">
                                        Sửa
                                    </div>
                                    <div 
                                        @click="openDeleteDialog" 
                                        class="px-2 py-[2.5] text-[12px] bg-white border rounded-md mr-2 hover:bg-[#f1f1f1] cursor-pointer"
                                    >
                                        Xóa
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <SongDelete :confirmClose="closeDeleteDialog" :visible="deleteDialog" :id="song.id" @update="handleDelete"></SongDelete>
        <SongAddOrUpdate :confirmClose="closeEditDialog" :visible="editDialog" @update="handleUpdate" :song="song"></SongAddOrUpdate>
    </div>
</template>