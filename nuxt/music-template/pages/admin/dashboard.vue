<script setup>
    definePageMeta({
        layout: 'admin',
        middleware: 'admin'
    })

    import { Line } from 'vue-chartjs';
    import {
        Chart as ChartJS,
        Title,
        Tooltip,
        Legend,
    } from 'chart.js';

    ChartJS.register(
        Title,
        Tooltip,
        Legend,
    );

    const songStore = useSongStore();
    const authStore = useAuthStore();

    const loadingStore = useLoadingStore();
    const isLoading = computed(() => loadingStore.getIsLoading);
    
    const data = ref(await authStore.getNewUserByMonths());
    
    const trendingSong = ref([]);
    const remarkableUser = ref([]);
    const newSong = ref([]);

    const chartData = ref({
        labels: [], // Nhãn cho các tháng
        datasets: [
            {
                label: 'Số người đăng ký', // Nhãn cho dữ liệu
                backgroundColor: '#f87979',
                borderColor: '#f87979',
                data: [], // Dữ liệu số người đăng ký
                fill: false,
            },
        ],
    });

    onMounted(async () => {
        loadingStore.setLoading(true);
        try{
            trendingSong.value = await songStore.getTrendingSong();
            remarkableUser.value = await authStore.getRemarkableUser();
            newSong.value = await songStore.getNewSong();

        } catch (error) {
            console.error('Error fetching songs:', error);
        } finally {
            loadingStore.setLoading(false);
        }
    });

    // Đổ dữ liệu vào biểu đồ từ data được truyền vào
    data.value.forEach(item => {
        chartData.value.labels.push('Tháng ' + item.month); // Thêm nhãn của từng tháng vào mảng nhãn
        chartData.value.datasets[0].data.push(item.total); // Thêm dữ liệu số người đăng ký của từng tháng vào mảng dữ liệu
    });

    const chartOptions = ref({
        responsive: true,
        maintainAspectRatio: false,
    });

</script>

<template>
    <div>
        <Loading v-if="isLoading" />
        <div class="bg-white p-[20px]">
            <h3 class="font-bold text-[20px]">Lượng người đăng ký</h3>
            <div>
                <Line :data="chartData" :options="chartOptions" />
            </div>
        </div>

        <div class="grid lg:grid-cols-12 mt-[20px] gap-10">
            <div class="col-span-8 bg-white p-[20px]">
                <h3 class="font-bold text-[20px] mb-1">Bài hát nổi bật</h3>

                <div class="border"></div>

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 w-[150px]">Hình Ảnh</th>
                            <th class="px-4 py-2 max-w-[50%]">Tên bài hát</th>
                            <th class="px-4 py-2">Nghệ Sĩ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr 
                            v-for="song in trendingSong"
                            :key="song"
                            class="border-t">
                            <td class="px-2 py-2 h-full">
                                <img 
                                    class="w-[70px] h-[70px] m-auto bg-cover rounded-full" 
                                    :src="song.image" 
                                    alt=""
                                >
                            </td>
                            <td class="px-4 py-2 text-center">
                                <p class="line-clamp-2">
                                    {{ song.name }}
                                </p>
                            </td>
                            <td class="px-4 py-2 text-center">{{ song.user.name }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="col-span-4 bg-white p-[20px]">
                <h3 class="font-bold text-[20px] mb-1">Nghệ sĩ nổi bật</h3>

                <div class="border"></div>

                <div>
                    <div
                        v-for="user in remarkableUser" 
                        :key="user"
                        class="flex items-center p-2 border-b">
                        <div>
                            <img class="w-[40px] h-[40px] rounded-full" 
                                :src="user.image ? user.image : 'https://upload.wikimedia.org/wikipedia/commons/a/a6/Ladies%27_Code_on_May_24%2C_2013.jpg'" 
                                alt="">
                        </div>
                        <div class="flex-1 flex justify-between ml-[10px]">
                            <span>{{ user.name }}</span>
                            <span>{{ user.songs_count }} bài hát</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-span-8 bg-white p-[20px]">
                <h3 class="font-bold text-[20px] mb-1">Bài hát mới</h3>

                <div class="border"></div>

                <table class="table-auto w-full">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 w-[150px]">Hình Ảnh</th>
                            <th class="px-4 py-2 max-w-[50%]">Tên bài hát</th>
                            <th class="px-4 py-2">Nghệ Sĩ</th>
                            <th class="px-4 py-2">Ngày đăng</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr 
                            v-for="song in newSong"
                            :key="song"
                            class="border-t">
                            <td class="px-2 py-2 h-full">
                                <img class="w-[70px] h-[70px] m-auto bg-cover rounded-full" :src="song.image" alt="">
                            </td>
                            <td class="px-4 py-2 text-center">
                                <p class="line-clamp-2">
                                    {{ song.name }}
                                </p>
                            </td>
                            <td class="px-4 py-2 text-center">{{ song.user.name }}</td>
                            <td class="px-4 py-2 text-center">{{ song.created_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;  
    overflow: hidden;
    text-overflow: ellipsis;
}
</style>
