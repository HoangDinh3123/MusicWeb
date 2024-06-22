<script setup>
</script>

<template>
    <div class="flex">
        <Alert></Alert>
        <LayoutsAdminSidebar class="flex-none z-50"></LayoutsAdminSidebar>
        <div class="mt-[60px] w-full h-screen overflow-auto lg:flex-1 lg:ml-[200px] lg:mt-0 px-2 lg:p-6 pt-6 z-30 bg-[#f3f7fa]">
            <slot></slot>
        </div>
    </div>
</template>