<script setup>
    const { $pusher } = useNuxtApp();

    const props = defineProps({
        song_id: Number,
        comment: {
            type: Object,
            default: NaN
        },
    })

    const authStore = useAuthStore();
    const commentStore = useCommentStore();

    onMounted(async () => {
        const channel = $pusher.subscribe('reply-' + props.comment.id);
        channel.bind('reply', (data, commentId) => {
                props.comment.replies.push(data.data);
        });
    });
    
    const reply = (content) => {
        commentStore.addComment({
            user_id: authStore.currentUser.id,
            song_id: props.song_id,
            content: content,
            parent_id: props.comment.id
        });
    }

</script>

<template>
    <div>
        <div class="flex">
            <div class="max-w-10 h-10">
                <img 
                    :src="comment.user.image ? comment.user.image : 'https://flatfull.com/themes/pulse/images/a0.jpg'" 
                    alt="" 
                    class="rounded-full"
                >
            </div>

            <div class="flex-1 ml-2">
                <div class="flex items-center">
                    <NuxtLink to="/artist/1" class="text-[14px]">{{ comment.user.name }}</NuxtLink>
                    <span class="ml-2 text-[12px] text-[#d0d0d0]">{{ formatDate(comment.created_at) }}</span>
                </div>

                <p class="text-[14px] mb-4">{{ comment.content }}</p>

                <CommentReplyForm :reply="reply"></CommentReplyForm>
            </div>
        </div>

        <div v-if="comment.replies" class="ml-10 mb-10">
            <div 
                v-for="item in comment.replies"
                :key="item"
                class="flex mb-2">
                <div class="max-w-10 h-10">
                    <img src="https://flatfull.com/themes/pulse/images/a0.jpg" alt="" class="rounded-full">
                </div>

                <div class="flex-1 ml-2">
                    <div class="flex items-center">
                        <NuxtLink to="/artist/1" class="text-[14px]">{{ item.user.name }}</NuxtLink>
                        <span class="ml-2 text-[12px] text-[#d0d0d0]">{{ formatDate(item.created_at) }}</span>
                    </div>

                    <p class="text-[14px] mb-4">{{ item.content }}</p>
                </div>
            </div>
        </div>
    </div>
</template>