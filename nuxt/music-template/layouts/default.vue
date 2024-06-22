<script setup>
</script>

<template>
    <div class="flex flex-col">
        <Alert></Alert>
        <div class="flex flex-1">
            <LayoutsDefaultSidebar class="flex-none z-50"></LayoutsDefaultSidebar>
            <div class="mt-[60px] w-full lg:flex-1 lg:ml-[200px] lg:mt-0 px-2 lg:p-6 pt-6 z-30">
                <slot></slot>
            </div>
        </div>
        <LayoutsDefaultPlayer class="flex-none z-[1000]"></LayoutsDefaultPlayer>
    </div>
</template>