<script setup>
    import {UiSidebar} from '~/data/BasicComponents.ts';
    const selected = ref(1);
    const isSidebarVisible = ref(false);
    const isUserMenu = ref(false);
    const dialogVisible = ref(false);
    
    const authStore = useAuthStore();
    const user = ref('');

    onMounted(async () => {
        await authStore.setLoggedStatus();
        if(authStore.getLogged) {
            await authStore.getInfo();
            user.value = authStore.getUserData;
        }
    });

    const logout = () => {
        authStore.logout();
        user.value = '';
    }

    const openSidebar = () => {
        isSidebarVisible.value = !isSidebarVisible.value;
    }

    const openDialog = () => {
        dialogVisible.value = true;
    }

    const closeDialog = () => {
        dialogVisible.value = false;
    }
</script>

<template>
    <div class="fixed w-full">
        <div class="fixed top-0 w-full h-[56px] shadow-md bg-white lg:hidden">
            <div class="flex justify-between px-4">
                <NuxtLink to="/" class="h-[56px] flex items-center cursor-pointer">
                    <div class="lg:hidden">
                        <Icon name="ic:baseline-music-note" color="black" class="w-[32px] h-[32px]"/>
                    </div>
                    <div class="text-[20px] text-[#212121] lg:text-[#e5e6e7] font-[1000] ml-1">Dashboard</div>
                </NuxtLink>

                <button @click="openSidebar" class="lg:hidden">
                    <Icon name="ic:baseline-menu" color="#c7c7c7" class="w-[18px] h-[18px] z-[1001]"/>
                </button>
            </div>
        </div>

        <div 
            class="fixed left-0 top-0 w-1/2 md:w-1/3 lg:w-[200px] h-full bg-[#363c43] ease-out delay-200 duration-300 lg:translate-x-0 z-50" 
            :class="{'-translate-x-full': !isSidebarVisible}"
        >
            <div class="flex justify-between px-4">
                <div class=" h-[56px] flex items-center">
                    <Icon name="ic:baseline-music-note" color="white" class="w-[32px] h-[32px]"/>
                    <NuxtLink class="text-[20px] text-[#e5e6e7] font-[1000] ml-1">Dashboard</NuxtLink>
                </div>
            </div>

            <div class="h-full w-full">
                <ul class="mx-2">
                    <li
                        :class="{'active': selected == 1}"
                        @click="selected = 1"
                        class="hover:bg-[#5f4646] rounded-sm h-[28px] my-[2px] text-[#8c8f93] [&.active]:bg-[#02b875] [&.active]:text-white">
                        <SidebarItem :icon="'i-ic:baseline-dashboard'" :name="'Thống kê'" :path="'/admin/dashboard'"></SidebarItem>
                    </li>

                    <li
                        :class="{'active': selected == 2}"
                        @click="selected = 2"
                        class="hover:bg-[#5f4646] rounded-sm h-[28px] my-[2px] text-[#8c8f93] [&.active]:bg-[#02b875] [&.active]:text-white">
                        <SidebarItem :icon="'i-ic:baseline-category'" :name="'Thể loại'" :path="'/admin/genre'"></SidebarItem>
                    </li>

                    <li
                        :class="{'active': selected == 3}"
                        @click="selected = 3"
                        class="hover:bg-[#5f4646] rounded-sm h-[28px] my-[2px] text-[#8c8f93] [&.active]:bg-[#02b875] [&.active]:text-white">
                        <SidebarItem :icon="'i-ic:round-switch-account'" :name="'Người dùng'" :path="'/admin/user'"></SidebarItem>
                    </li>
                </ul>

                <div
                    @click="isUserMenu = !isUserMenu"
                    class="mt-[50px] cursor-pointer relative"
                >
                    <div class="px-4 py-3 flex items-center">
                        <img class="rounded-full h-[32px]" src="~/assets/images/a3.jpg" alt="">

                        <span class="ml-2 text-[14px] text-white">{{ user.name ? user.name: 'Khách' }}</span>
                    </div>

                    <div v-if="isUserMenu" class="absolute top-full w-[80%] bg-white rounded-sm text-[14px]">
                        <div v-if="authStore.getLogged">
                            <div class="border"></div>

                            <div 
                                @click="logout"
                                class="py-[3px] px-[20px]"
                            > 
                                Đăng xuất
                            </div>
                        </div>

                        <div v-else>
                            <NuxtLink to="/auth/login" class="block mt-2 h-[27px] py-[3px] px-[20px]"> Đăng nhập</NuxtLink>
                            <NuxtLink to="/auth/register" class="block mt-2 h-[27px] py-[3px] px-[20px]"> Đăng ký</NuxtLink>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div :class="{'hidden opacity-0': !isSidebarVisible}" @click="openSidebar" class="fixed w-screen h-screen top-0 left-0 bottom-0 right-0 lg:opacity-0 bg-gray-900 delay-75 bg-opacity-30 z-20"></div>

        <SearchDialog :isVisible="dialogVisible" :close="closeDialog"></SearchDialog>

    </div>
</template>
