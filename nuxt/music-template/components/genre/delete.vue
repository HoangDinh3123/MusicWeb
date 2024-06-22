<script setup>
    const emits = defineEmits(['update']);
    const props = defineProps({
        id: {
            type: Number,
        },
        visible: {
            type: Boolean,
            default: false
        },
        confirmClose: {
            type: Function
        },
    })

    const genreStore = useGenreStore();
    const alertStore = useAlertStore();

    const deleteConfirm = () => {
        genreStore.deleteGenre(props.id)
        .then(() => {
            emits('update');
            alertStore.successAlert('Đã xóa bài hát thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });;
    }
</script>

<template>
    <div 
        v-if="visible" 
        class="fixed pt-[200px] z-[1] left-[0px] top-[0px] w-full h-full overflow-auto bg-[rgb(110,107,107)] bg-[rgba(0,0,0,0.4)]"
    >

        <div class="bg-[#fefefe] mx-auto px-[26px] py-[80px] border border-[#888] w-full md:w-[500px] rounded-md" >
        <div class=" text-center">
            <p>Bạn có muốn xóa thể loại này?</p>
        </div>
        <div class="mt-[40px] flex justify-center ">
            <button @click="confirmClose" class="close w-[120px] h-[40px] rounded-md border border-[#00000033] text-[#00000033]">Hủy</button>
            <button @click="deleteConfirm" class="w-[120px] h-[40px] ml-[25px] rounded-md bg-[#f44336] text-white">Xóa</button>
        </div>
        </div>

    </div>
</template>