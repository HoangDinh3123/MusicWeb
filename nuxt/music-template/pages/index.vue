<script setup>
    import {test} from '~/data/BasicComponents.ts';

    const songStore = useSongStore();
    const listTrendingSong = ref([]);
    const listNewSong = ref([]);
    const loadingStore = useLoadingStore();
    const isLoading = computed(() => loadingStore.getIsLoading);
    const listAllSong = computed(() => songStore.getListSong);

    onMounted(async () => {
        loadingStore.setLoading(true);
        try{
            await songStore.getAllSong();
            listTrendingSong.value = await songStore.getTrendingSong();
            listNewSong.value = await songStore.getNewSong();
        } catch (error) {
            console.error('Error fetching songs:', error);
        } finally {
            loadingStore.setLoading(false);
        }
    })

</script>

<template>
    <div>
        <Loading v-if="isLoading" />
        <div>
            <h1 class="text-[40px] leading-[44px] mb-4 font-bold">Khám phá</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full">
                <div class="relative">
                    <swiper
                        :modules="[SwiperNavigation, SwiperPagination, SwiperAutoplay]"
                        :navigation="{nextEl: '.nextArrow', prevEl: '.prevArrow'}"
                        :pagination="{
                            clickable: true,
                        }"
                        :slidesPerView="1"
                        :loop="true"
                        :autoplay=" {
                            delay: 2000,
                            disableOnInteraction: false
                        }"
                        class="mySwiper w-full"
                    >
                        <swiper-slide
                            v-for="(item, index) in listAllSong.slice(0, 3)"
                            :key="index"    
                        >
                            <SongItem :song="item" :user="item.user"></SongItem>
                        </swiper-slide>
                    </swiper>

                    <div class="prevArrow w-[50px] h-[38px] z-10 absolute top-1/2 left-0 -mt-[20px] flex items-center justify-center cursor-pointer">
                        <Icon name="i-ic:baseline-arrow-back-ios" color="white" class="w-[14px] h-[14px]"/>
                    </div>
                    <div class="nextArrow w-[50px] h-[38px] z-10 absolute top-1/2 right-0 -mt-[20px] flex items-center justify-center cursor-pointer">
                        <Icon name="i-ic:baseline-arrow-forward-ios" color="white" class="w-[14px] h-[14px]"/>
                    </div>

                </div>

                <div class="grid grid-cols-2 gap-2 lg:gap-4">
                    <SongItem
                        v-for="(item, index) in listAllSong.slice(3, 7)"
                        :key="index"
                        :song="item"
                        :user="item.user"
                    ></SongItem>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 lg:gap-4 mt-4">
            <div class="col-span-9">
                <div>
                    <h2 class="font-bold text-[25px] mb-4">Top xu hướng</h2>
                    <div v-if="listTrendingSong?.length == 0">
                        <p>Không có bài hát trending</p>
                    </div>
                    <div>
                        <swiper
                            :modules="[ SwiperPagination]"
                            :pagination="{
                                clickable: true,
                            }"
                            :spaceBetween="30"
                            :breakpoints= "{
                                '@0.5': {
                                slidesPerView: 2,
                                spaceBetween: 20,
                                },
                                '@1.00': {
                                slidesPerView: 2,
                                spaceBetween: 20,
                                },
                                '@1.50': {
                                slidesPerView:  3,
                                spaceBetween: 30,
                                },

                            }"
                            class="mySwiper2 w-full"
                        >
                            <swiper-slide
                                v-for="(item, index) in listTrendingSong"
                                :key="index"   
                            >
                                <SongItem 
                                    :isTop="false" 
                                    :song="item" 
                                    :artist="item.user"
                                >
                                </SongItem>
                            </swiper-slide>
                        </swiper>
                    </div>
                </div>

                <div class="mb-9">
                    <h2 class="font-bold text-[25px] mb-4">Top bài hát mới</h2>

                    <div class="grid grid-cols-3 lg:grid-cols-4 gap-4">
                        <SongItem 
                            v-for="item in listNewSong"
                            :key="item"
                            :isTop="false" 
                            :song="item" 
                            :user="item.user"></SongItem>
                    </div>
                </div>

                <!-- <div class="my-8">
                    <h2 class="font-bold text-[25px] mb-4">Dành cho bạn</h2>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                        <div class="h-[84px]">
                            <SongHorizon></SongHorizon>
                        </div>
                        <div class="h-[84px]">
                            <SongHorizon></SongHorizon>
                        </div>
                        <div class="h-[84px]">
                            <SongHorizon></SongHorizon>
                        </div>
                    </div>
                </div> -->
            </div>

            <div class="col-span-3">
                <LayoutsDefaultLikedList></LayoutsDefaultLikedList>
            </div>
        </div>
    </div>
</template>

<style>
    .mySwiper .swiper-pagination {
        width: 76px !important;
    }
    .mySwiper .swiper-pagination-bullet {
        width: 10px;
        height: 4px;
        background-color: white !important;
        border-radius: 10px;
    }

    .mySwiper .swiper-pagination-bullet-active {
        width: 16px !important;
        transition: all ease-out;
    }

    .mySwiper2 {
        padding-bottom: 50px;
    }

    .mySwiper2 .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        background-color: green !important;
        border-radius: 10px;
    }

    .mySwiper2 .swiper-pagination-bullet-active {
        width: 16px !important;
        transition: all ease-out;
    }

</style>