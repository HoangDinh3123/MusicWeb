<script setup>
    const props = defineProps({
        songs: {
            type: Array,
            default: () => ([]) // Mặc định là một đối tượng trống nếu không có dữ liệu bài hát được truyền vào
        },
        visible: {
            type: Boolean,
            default: false
        },
        confirmClose: {
            type: Function
        },
    })

</script>

<template>
    <div 
         v-if="visible"
        class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50"
    >
        <div class="bg-[#fefefe] px-[26px] py-[80px] border border-[#888] rounded-md" >
            <table class="w-full whitespace-no-wrap">
                <thead>
                    <tr
                        class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
                    >
                        <th class="px-4 py-3">Bài hát</th>
                        <th class="px-4 py-3">Ngày đăng</th>
                        <th class="px-4 py-3">Lượt nghe</th>
                        <th class="px-4 py-3">Lượt like</th>
                    </tr>
                </thead>

                <tbody
                    class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
                >
                    <tr 
                        v-for="item in songs"
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
                                    :src="item.image"
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
                                </div>
                            </div>
                        </td>

                        <td class="px-4 py-3 text-sm">
                            {{ formatDate(item.created_at) }}
                        </td>

                        <td class="px-4 py-3 text-sm">
                            {{ item.total_play_count }}
                        </td>

                        <td class="px-4 py-3 text-sm">
                            {{ item.total_likes }}
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="mt-[40px] flex justify-center ">
                <button @click="confirmClose" class="close w-[120px] h-[40px] rounded-md border border-[#00000033] text-[#00000033]">Đóng</button>
            </div>
        </div>

    </div>
</template>