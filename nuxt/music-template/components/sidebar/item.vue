<script setup>
    const props = defineProps({
        icon: '',
        name: '',
        path: ''
    });
</script>

<template>
    <NuxtLink :to="path" class="w-full h-full px-2 flex items-center justify-between font-semibold">
        <div class="flex">
            <Icon :name="icon" color="#e5e6e7" class="w-[18px] h-[18px]"/>
            <span class="text-[14px] ml-[16px]">{{name}}</span>
        </div>

    </NuxtLink>
</template>