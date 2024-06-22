<script setup>
    const props = defineProps({
        id: {
            type: Number,
            default: NaN
        },
        isLike: {
            type: Boolean,
            default: false,
        },
        iconColor: {
            type: String,
            default: 'white'
        }
    });

    const songStore = useSongStore();
    const authStore = useAuthStore();
    const alertStore = useAlertStore();

    const checkLiked = ref(props.isLike);

    const like = async () => {
        if (authStore.currentUser) {

            try {
                const response = await songStore.like({ song_id: props.id });

                checkLiked.value = !checkLiked.value;

                if (response) {
                    alertStore.successAlert('Đã thêm bài hát vào yêu thích');
                } else {
                    alertStore.successAlert('Đã xóa bài hát khỏi yêu thích');
                }
            } catch (error) {
                alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
            }
        }
        else alertStore.errorAlert('Bạn phải đăng nhập!!');
    };

    const isMenu = ref(false);

    const openMenu = () => {
        isMenu.value = !isMenu.value;
    };
</script>

<template>
    <div>
        <div class="relative flex justify-end">
            <div class="cursor-pointer" @click="like">
                <Icon 
                    name="i-mdi:cards-heart-outline" 
                    :color="iconColor" 
                    class="w-[14px] h-[14px]"
                    v-if="checkLiked !== true"
                />

                <Icon 
                    name="i-ic:baseline-favorite" 
                    :color="iconColor" 
                    class="w-[14px] h-[14px]"
                    v-if="checkLiked == true"
                />
            </div>

            <div @click="openMenu" class="ml-1 cursor-pointer">
                <Icon name="i-mdi:dots-horizontal" :color="iconColor" class="w-[14px] h-[14px]"/>
            </div>

            <SongMenu :isOpen="isMenu" :id="id"></SongMenu>
        </div>
    </div>
</template>
