<script setup>
    definePageMeta({
        layout: false,
    })
</script>

<template>
    <div class=" h-screen flex justify-center items-center">
        <div>
            <h1 class="text-6xl font-semibold text-gray-700 dark:text-gray-200 text-center">
                404
            </h1>

            <p class="text-gray-700 dark:text-gray-300">
                Không tìm thấy trang!!
                <NuxtLink
                    to="/"
                    class="text-purple-600 hover:underline dark:text-purple-300"
                >
                Quay lại trang chủ
                </NuxtLink>
                .
            </p>
        </div>
    </div>
</template>