<script setup>
    definePageMeta({
        layout: false
    })
    import { useRouter } from 'vue-router'; // Import useRouter
    const router = useRouter();
    const authStore = useAuthStore();

    const errorMessage = ref('');
    const email = ref('');
    const password = ref('');

    const login = () => {
        authStore.login({
            email: email.value, 
            password: password.value
        })
        .then((response) => {
            if(response.role === 1)
            {
                router.push('/admin/dashboard');
            }
            else router.push('/');
        }).catch(error => {
            errorMessage.value = 'Thông tin tài khoản hoặc mật khẩu không chính xác.'
        });
    }

</script>


<template>
    <div class="h-screen px-10 py-10">
        <div class="md:grid grid-cols-2 gap-4 h-full">
            <div>
                <h1 class="text-[25px] font-bold">Welcome to the music web</h1>

                <h3 class="text-[#ff6347] mt-4">{{ errorMessage }}</h3>
                <form @submit.prevent="login">
                    <div class="h-[50px] w-full mt-4">
                        <input 
                            v-model="email"
                            class="h-full w-full md:w-[80%] focus:outline-none border-b" 
                            placeholder="Email"
                            type="text"
                        >
                    </div>
                    <div class="h-[50px] w-full mt-4">
                        <input 
                            v-model="password"
                            class="h-full w-full md:w-[80%] focus:outline-none border-b" 
                            placeholder="Password" 
                            type="password"
                        >
                    </div>

                    <div class="flex items-center h-[50px] mt-4">
                        <button 
                            class="h-full px-10 bg-slate-300 rounded-md">Đăng nhập</button>
                        <div>
                            <span class="ml-4">Chưa có tài khoản? 
                                <NuxtLink 
                                    to="/auth/register" 
                                    class="text-[#ff4d4d]"
                                >
                                    Đăng ký
                                </NuxtLink> 
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="hidden md:block">
                <img class="w-full h-full rounded-md" src="~/assets/images/auth.jpg" alt="">
            </div>
        </div>
    </div>
</template>