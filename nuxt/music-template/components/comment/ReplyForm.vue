<script setup>
    const isReply = ref(false);

    const props = defineProps({
        reply: {
            type: Function,
        },
    })

    const content = ref('');

    const submitReply = () => {
        props.reply(content.value);
        isReply.value = false;
    }
</script>

<template>
    <div>
        <div
            @click="isReply = !isReply"
            class="flex cursor-pointer">
            <Icon name="i-ic:baseline-reply" color="#7a7a7a" class="w-[20px] h-[20px]"></Icon>
            <span class="select-none">Reply</span>
        </div>

        <div
            :class="{'h-[200px]' : isReply}"
            class="my-4 h-0 overflow-hidden shadow-2xl flex flex-col transition-height duration-500 ease-in-out">
            <div>
                <div class="h-[80%]">
                    <textarea 
                        v-model="content"
                        placeholder="Type somethings..."
                        class="w-full h-full px-3 py-2 focus:outline-none" ></textarea>
                </div>

                <div class="p-4 flex-1 flex justify-end">
                    <button @click="submitReply" class="px-3 py-[5px] bg-[#5bc0de] rounded-md text-white">Post</button>
                </div>
            </div>
        </div>
    </div>
</template>