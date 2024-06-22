<script setup>

    const songStore = useSongStore();
    const authStore = useAuthStore();

    const isVisibleList = ref(false);
    const isPlaying = ref(1); /** 1: not yet play, 2: playing, 3: pause **/
    const artist = ref('');
    const current = ref(null);
    const audioPlayer = ref(null);
    const currentTime = ref(0);
    const duration = ref(0);
    const volume = ref(100);
    const isReplay = ref(false);
    const isShuffle = ref(false);
    const interaction = ref('');
    const currentUser = ref('');

    onMounted(async () => {
        await songStore.setQueue();

        await songStore.getSong();

        await updatePlayerWithCurrentSong();
    });

    const queueSong = computed(() => songStore.getQueue);

    const index = computed(() => {
        return queueSong.value.findIndex(song => song.id === (current.value ? current.value.id : null));
    });

    const updatePlayerWithCurrentSong = async () => {
        if (current.value) {
            artist.value = current.value.user;
            if(audioPlayer.value) {
                audioPlayer.value.src = current.value.path;
            }
        }
    };

    watch(() => songStore.getCurrentSong, (newCurrentSong) => {
        current.value = newCurrentSong;
        updatePlayerWithCurrentSong();
    });

    const like = async () => {
        if (authStore.currentUser) {
            songStore.like({
                song_id: current.value.id,
            });
        }
    };

    const deleteSong = (id) => {
        songStore.deleteSongQueue(id);
    };

    const playOrUnpause = () => {
        if (isPlaying.value == 1) {
            play();
        } else if (isPlaying.value == 3) {
            unpause();
        }
    };

    const play = async () => {
        if (current.value) {
            await songStore.play(
                {
                    song_id: current.value.id
                }
            );

            audioPlayer.value.src = current.value.path;

            audioPlayer.value.oncanplaythrough = () => {
                audioPlayer.value.play();
                isPlaying.value = 2;
                duration.value = audioPlayer.value.duration;
                audioPlayer.value.ontimeupdate = () => {
                    currentTime.value = audioPlayer.value.currentTime;
                };
            };
        }
    };

    const pause = () => {
        audioPlayer.value.pause();
        isPlaying.value = 3;
    };

    const unpause = () => {
        audioPlayer.value.play();
        isPlaying.value = 2;
    };

    const next = () => {
        let changeIndex = index.value;
        if (isShuffle.value) {
            changeIndex = Math.floor(Math.random() * queueSong.value.length);
        } else {
            changeIndex = (changeIndex + 1) % queueSong.value.length;
        }
        current.value = queueSong.value[changeIndex];
        play();
    };

    const prev = () => {
        let changeIndex = index.value;
        if (changeIndex > 0) {
            changeIndex -= 1;
        } else {
            changeIndex = queueSong.value.length - 1;
        }
        current.value = queueSong.value[changeIndex];
        play();
    };

    const seeking = () => {
        audioPlayer.value.currentTime = currentTime.value;
    };

    const changeVolume = () => {
        audioPlayer.value.volume = volume.value / 100; // volume range 0 to 1
    };

    const handleEnded = () => {
        if (!isReplay.value) {
            next();
        } else {
            play();
        }
    };

    const openList = () => {
        isVisibleList.value = !isVisibleList.value;
    };

    const replay = () => {
        isReplay.value = !isReplay.value;
    };

    const shuffle = () => {
        isShuffle.value = !isShuffle.value;
    };
</script>

<template>
    <div v-if="current">
        <audio ref="audioPlayer" @ended="handleEnded"></audio>
        <div class="fixed w-full h-[55px] bottom-0 flex bg-[#363c43] z-10">
            <div class="w-[55px] h-full">
                <NuxtLink to="/">
                    <img :src="current.image" alt=""
                    class="w-full h-full">
                </NuxtLink>
            </div>

            <div class="flex-1 h-full flex flex-col items-center relative">
                <input 
                    class="seek cursor-pointer w-full h-1 bg-[#595e63] rounded-lg overflow-hidden appearance-none thumb:-webkit-appearance-none thumb:bg-white absolute top-0" 
                    type="range" 
                    min="0" 
                    :max="duration" 
                    step="1" 
                    v-model="currentTime"
                    @input="seeking" />

                <div class="w-full flex-1 pl-[15px] flex justify-between items-center">
                    <div class="w-[230px] h-full flex items-center">
                        <div class="flex-1 flex flex-col">
                            <NuxtLink to="/" class="text-white text-[11px]">{{current.name ? current.name: 'Unknown'}}</NuxtLink>
                            <NuxtLink to="/" class="text-[#FFFFFFDE] text-[11px]">{{artist.name ? artist.name: 'Unknown'}}</NuxtLink>
                        </div>

                        <div class="w-[44.4px] px-4">
                            <button
                                @click="like"
                                class="w-[30px] h-[30px] hover:bg-gray-700">
                                <Icon 
                                    v-if="!current?.liked_by_user"
                                    name="ic:baseline-favorite-border" 
                                    color="#e5e6e7" 
                                    class="w-[18px] h-[18px]"/>

                                <Icon 
                                    v-else
                                    name="i-ic:baseline-favorite" 
                                    color="#e5e6e7" 
                                    class="w-[18px] h-[18px]"/>
                            </button>
                        </div>
                    </div>

                    <div class="flex-1 flex justify-center">
                        <button @click="shuffle" class="w-[40px] h-[40px] hidden lg:block">
                            <Icon name="ic:baseline-shuffle" :color="isShuffle ? 'white' : '#898d91'" class="w-[20px] h-[20px]"/>
                        </button>

                        <button @click="prev" class="w-[40px] h-[40px]">
                            <Icon name="ic:baseline-skip-previous" color="#e5e6e7" class="w-[20px] h-[20px]"/>
                        </button>

                        <button v-if="isPlaying == 1 || isPlaying == 3" @click="playOrUnpause" class="w-[40px] h-[40px]">
                            <Icon name="mdi:arrow-right-drop-circle" color="#e5e6e7" class="w-[35px] h-[35px]"/>
                        </button>

                        <button v-if="isPlaying == 2" @click="pause" class="w-[40px] h-[40px]">
                            <Icon name="i-mdi:pause-circle" color="#e5e6e7" class="w-[35px] h-[35px]"/>
                        </button>

                        <button @click="next" class="w-[40px] h-[40px]">
                            <Icon name="ic:baseline-skip-next" color="#e5e6e7" class="w-[20px] h-[20px]"/>
                        </button>

                        <button @click="replay" class="w-[40px] h-[40px] hidden lg:block">
                            <Icon name="i-mdi:replay" :color="isReplay ? 'white' : '#898d91'" class="w-[20px] h-[20px]"/>
                        </button>   
                    </div>

                    <div class="flex items-center h-[40px]">
                        <span class="text-[#FFFFFFDE] text-[11px] mr-4 hidden lg:block">{{formatTime(currentTime)}}/ {{ formatTime(duration) }}</span>

                        <div class="ml-2 items-center hidden lg:flex">
                            <div class="cursor-pointer flex items-center">
                                <Icon name="i-mdi:volume" color="white" class="w-[20px] h-[20px]"/>
                            </div>

                            <input 
                                class="volume cursor-pointer ml-4 w-full h-1 bg-[#595e63] rounded-lg overflow-hidden appearance-none thumb:-webkit-appearance-none thumb:bg-white" 
                                type="range" 
                                min="0" 
                                max="100" 
                                step="1" 
                                v-model="volume"
                                @input="changeVolume" />
                        </div>
                    </div>
                    
                    <div class="relative h-[40px]">
                        <div @click="openList"  class="w-[40px] h-full cursor-pointer flex items-center justify-center right-0">
                            <Icon name="i-mdi:menu" color="white" class="w-[20px] h-[20px]"/>
                        </div>
                    </div>
                    
                    <ul class="absolute w-screen md:w-[478px] bottom-[55px] bg-[#363c43] right-0 " :class="{'hidden': !isVisibleList}">
                        <li 
                            v-for="(song, index) in queueSong"
                            :key="index"
                            class="flex justify-between px-2 py-[10px] border-b-2 border-b-[#3e454c]"
                        >
                            <div class="flex items-center">
                                <span v-if="current.name !== song.name" class="text-[#FFFFFFDE] text-[13px] mr-[10px]">{{index}}</span>
                                <Icon v-if="current.name === song.name" name="i-ic:outline-volume-up" color="white" class="w-[15px] h-[15px] mr-[10px]"/>
                                <span class="text-white text-[12px] mr-[10px]">{{song.name}}</span>
                                <span class="text-[#FFFFFFDE] text-[10.2px]">{{song.user.name}}</span>
                            </div>

                            <div @click="deleteSong(song.id)" class="cursor-pointer">
                                <Icon name="i-ic:baseline-delete-forever" color="white" class="w-[24px] h-[20px]"/>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<style>
    .seek::-webkit-slider-thumb,
    .volume::-webkit-slider-thumb {
        -webkit-appearance: none;
        width: 5px;
        height: 20px;
        background: white;
        box-shadow: -1000px 0 0 1000px green;
    }
    
</style>
