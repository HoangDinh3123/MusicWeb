<script setup>
    const emits = defineEmits(['update']);

    const props = defineProps({
        song: {
            type: Object,
            default: () => ({})
        },
        album_id: {
            type: Number,
            default: null
        },
        visible: {
            type: Boolean,
            default: false
        },
        confirmClose: {
            type: Function
        },
    })

    const router = useRouter();
    const songStore = useSongStore();
    const authStore = useAuthStore();
    const genreStore = useGenreStore();
    const alertStore = useAlertStore();

    const name = ref('');
    const genres = ref([]);
    const selectedGenre = ref([]);
    const description = ref('');
    const image = ref('');
    const songUrl = ref('');
    const previewSongUrl = ref('Upload');
    const previewImage = ref('');
    const previewGenre = ref([]);
    const oldGenre = ref([]);
    const deleteGenres = ref([]);

    if (props.song !== null && props.song.genres) {
        oldGenre.value = props.song.genres;
        name.value = props.song.name;
        description.value = props.song.description;
        previewSongUrl.value = props.song.path;
        previewImage.value = props.song.image;
        previewGenre.value = oldGenre.value.slice() || [];
    }

   if(genreStore.getListGenre == null) {
        genreStore.getAllGenre();
   } 

    const setPreviewImage = (event) => {
        const file = event.target.files[0];
        image.value = file;
        const reader = new FileReader();
        reader.onload = () => {
            previewImage.value = reader.result; // Gán đường dẫn xem trước cho ảnh
        };

        reader.readAsDataURL(file);
    };

    const addGenre = () => {
        if (selectedGenre.value) {
            if (!previewGenre.value.some(item => item.id == selectedGenre.value)) {
                previewGenre.value.push(genreStore.listGenre.find(item => item.id == selectedGenre.value[0]))
                selectedGenre.value = ''; // Đặt lại selectedGenre để chuẩn bị cho lần chọn tiếp theo
            }
        }
    };

    const deleteSeletedGenre = (id) => {
        const index = previewGenre.value.findIndex(item => item.id === id);
        if (index !== -1) {
            previewGenre.value.splice(index, 1); // Xóa 1 phần tử tại vị trí index
        }
    }

    const previewSong = (event) => {
        const file = event.target.files[0];
        songUrl.value = file;
        // Đường dẫn file bài hát được lưu vào songUrl
        previewSongUrl.value = file.name;
    };

    //Add
    const addSong = () => {
        previewGenre.value.forEach(item =>{
            genres.value.push({ genre_id: item.id });
        })

        songStore.add({
            user_id: authStore.currentUser.id,
            album_id: props.album_id,
            name: name.value,
            description: description.value,
            genres: genres.value,
            image: image.value,
            path: songUrl.value 
        })
        .then((newSong) => {
            emits('update', newSong);
            alertStore.successAlert('Đã thêm bài hát thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }

    //Edit

    const editSong = () => {
        //Lay ra nhung genre moi
        const newGenres = previewGenre.value.filter(item => !oldGenre.value.some(oldItem => oldItem.id === item.id));
        newGenres.forEach(item =>{
            genres.value.push({ genre_id: item.id });
        });

        //Lay ra nhung genre se bi xoa
        const listDelete = oldGenre.value.filter(item => !previewGenre.value.some(oldItem => oldItem.id === item.id));
        listDelete.forEach(item =>{
            deleteGenres.value.push(item.id);
        });

        const updateData = {
            name: name.value,
            description: description.value,
            genres: genres.value,
            genres_to_delete: deleteGenres.value,
        };

        if (image.value) {
            updateData.image = image.value;
        }

        if (songUrl.value) {
            updateData.path = songUrl.value;
        }

        songStore.edit(
            props.song.id, 
            authStore.currentUser.id,
            {
                updateData
            }
        )
        .then((songUpdated) => {
            oldGenre.value = previewGenre.value.map(proxyObj => Object.assign({}, proxyObj));
            genres.value = [];
            deleteGenres.value = [];
            emits('update', songUpdated);
            alertStore.successAlert('Đã cập nhật bài hát thành công');
        })
        .catch(error => {
            alertStore.errorAlert('Có lỗi xảy ra khi thực hiện thao tác');
        });
    }
</script>

<template>
    <div>
        <div 
            v-if="visible"
            class="fixed z-[50] left-[0px] top-[0px] w-full h-full overflow-auto bg-[rgb(110,107,107)] bg-[rgba(0,0,0,0.4)]"
        >
            <form @submit.prevent="song.id ? editSong() : addSong()" enctype="multipart/form-data">
                <div class="bg-[#fefefe] mx-auto px-[26px] py-[80px] border border-[#888] w-full md:w-[1000px] rounded-md" >
                    
                    <div class="mb-3">
                        <label for="" class="mb-3 block">Tên bài hát</label>
                        <input
                            v-model="name" 
                            type="text" 
                            class="w-full py-3 px-3 border focus:outline-none">
                    </div>
                    <div class="mb-3">
                        <label for="" class="mb-3 block">Chọn thể loại</label>
                        <select 
                            @change="addGenre" 
                            v-model="selectedGenre"
                            multiple 
                            name="" 
                            id="" 
                            class="w-full py-3 px-3 border focus:outline-none"
                        >
                            <option
                                v-for="item in genreStore.getListGenre" 
                                :key="item"
                                :value="item.id">
                                {{ item.name }}
                            </option>
                        </select>
                    </div>

                    <div v-if="previewGenre" class="mb-5">
                        <div
                            v-for="item in previewGenre"
                            :key="item" 
                            @click="deleteSeletedGenre(item.id)"
                            class="relative px-1 min-w-[40px] h-[20px] float-left mr-2 bg-[#f1f1f1] rounded-lg flex items-center cursor-pointer">
                            {{ item.name }}
                            
                            <Icon name="i-mdi:alpha-x-circle" color="black" class="w-[14px] h-[14px] absolute right-0"/>
                        </div>

                    </div>
                    
                    <div class="mb-3 clear-both">
                        <label for="textarea" class="mb-3 block">Mô tả bài hát</label>
                        <CommentEditor id="textarea" v-model="description"></CommentEditor>
                    </div>

                    <div class="text-center mb-10">
                        <label for="image" class="block mb-5 cursor-pointer">Chọn ảnh</label>
                        <input 
                            id="image" 
                            type="file" 
                            accept="image/*"
                            @change="setPreviewImage($event)" 
                            class="hidden"> 
                        <img 
                            class="m-auto w-[200px] h-[200px] rounded-full bg-cover"
                            :src="previewImage" 
                            alt="">
                    </div>

                    <div>
                        <label for="song">Tải bài hát</label>

                        <label 
                            for="song" 
                            class="block w-full text-center py-[100px] mt-[25px] border border-dashed border-[#0000001A] cursor-pointer"
                            >{{ previewSongUrl }}
                        </label>
                        <input 
                            id="song" 
                            type="file" 
                            accept="audio/*" 
                            @change="previewSong($event)" class="hidden">
                    </div>

                    <div class="mt-[40px] flex justify-center ">
                        <div @click="confirmClose" class="flex items-center justify-center w-[120px] h-[40px] rounded-md border border-[#00000033] text-[#00000033] cursor-pointer">Hủy</div>
                        <button v-if="song.id" class="w-[120px] h-[40px] ml-[25px] rounded-md bg-[#f44336] text-white">Cập nhật</button>
                        <button v-else class="w-[120px] h-[40px] ml-[25px] rounded-md bg-[#f44336] text-white">Thêm bài hát</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>