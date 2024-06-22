<script setup>
    const props = defineProps({
        sum_like: Number,
        sum_play: Number
    })
    
</script>

<template>
    <div class="text-[10.4px] text-[#818a91] mt-1">
        <div class="flex items-center">
            <div class="mr-2 flex items-center">
                <Icon name="i-mdi:play" color="#818a91" class="w-[15px] h-[15px]"/>
                <span class="ml-[2px]">{{ sum_play }}</span>
            </div>

            <div class="mr-2 flex items-center">
                <Icon name="i-mdi:cards-heart" color="#818a91" class="w-[13px] h-[13px]"/>
                <span class="ml-[3px]">{{ sum_like }}</span>
            </div>
        </div>
    </div>
</template>