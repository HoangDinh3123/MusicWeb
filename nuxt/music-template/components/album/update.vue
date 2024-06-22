<script setup>
    const emits = defineEmits(['update']);
    const props = defineProps({
        album: {
            type: Object,
            default: () => ({})
        },
        visible: {
            type: Boolean,
            default: false
        },
        confirmClose: {
            type: Function
        },
    })

    const albumStore = useAlbumStore();
    const authStore = useAuthStore();
    const alertStore = useAlertStore();

    const name = ref('');
    const image =ref('');
    const previewImage = ref('');

    if(props.album !== null) {
        name.value = props.album.name;
        previewImage.value = props.album.image;
    }

    const handleFileChange = (event) => {
        const file = event.target.files[0];
        image.value = file;

        const reader = new FileReader();
        reader.onload = () => {
            previewImage.value = reader.result; // Gán đường dẫn xem trước cho ảnh
        };

        reader.readAsDataURL(file);
    };

    const add = () => {
        albumStore.addAlbum(
            {
                user_id: authStore.currentUser.id,
                name: name.value,
                image: image.value
            }
        ).then(() => {
            emits('update');
            alertStore.successAlert('Đã thêm album thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    };

    const edit = () => {
        const albumData = {
            name: name.value,
            ...(image.value && { image: image.value })
        };

        albumStore.updateAlbum(
            props.album.id,
            albumData
        ).then(() => {
            emits('update');
            alertStore.successAlert('Đã cập nhật album thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    };
</script>

<template>
    <div 
        v-if="visible" 
        class="fixed pt-[200px] z-[20] left-[0px] top-[0px] w-full h-full overflow-auto bg-[rgb(110,107,107)] bg-[rgba(0,0,0,0.4)]"
    >

        <div class="bg-[#fefefe] mx-auto px-[26px] py-[80px] border border-[#888] w-full md:w-[500px] rounded-md" >
            <form @submit.prevent="album.id ? edit() : add()" enctype="multipart/form-data">
                <div>
                    <input 
                        v-model="name"
                        type="text" 
                        placeholder="Tên Album" 
                        class="w-full py-[20px] px-2 border focus:outline-none rounded-b-md">
                </div>

                <div class="mt-[20px]">
                    <img :src="previewImage" alt="" class="w-[200px] h-[200px] rounded-md mb-[20px]">
                    <input type="file" accept="image/*"  @change="handleFileChange">
                </div>

                <div class="mt-[40px] flex justify-center ">
                    <div @click="confirmClose" class="close w-[120px] h-[40px] rounded-md border border-[#00000033] text-[#00000033] flex items-center justify-center cursor-pointer">Hủy</div>
                    <button class="w-[120px] h-[40px] ml-[25px] rounded-md bg-[#f44336] text-white">Thêm</button>
                </div>
            </form>
        </div>

    </div>
</template>