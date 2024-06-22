<script setup>
    definePageMeta({
            layout: false
        })
    import { useRouter } from 'vue-router'; // Import useRouter
    const router = useRouter();
    const authStore = useAuthStore();
    const alertStore = useAlertStore();

    const name = ref('');
    const email = ref('');
    const gender = ref('');
    const password = ref('');
    const password_confirmation = ref('');

    const register = () => {
        authStore.register({
            name: name.value,
            email: email.value,
            gender: gender.value,
            password: password.value,
            password_confirmation: password_confirmation.value
        })
        .then(() => {
            router.push('/auth/login');
        })
        .catch(error => {
            alertStore.errorAlert('Vui lòng kiểm tra lại thông tin');
        });
    }
        
</script>


<template>
    <div class="h-screen px-10 py-10">
        <Alert></Alert>
        <div class="md:grid grid-cols-2 gap-4 h-full">
            <div>
                <h1 class="text-[25px] font-bold">Chào mừng đến với thế giới âm nhạc</h1>
                <form @submit.prevent="register">
                    <div class="h-[50px] w-full">
                        <input 
                            v-model="name"
                            class="h-full w-full md:w-[80%] focus:outline-none border-b" 
                            placeholder="Tên của bạn" type="text">
                    </div>

                    <div class="flex mt-4">
                        <div class="flex">
                            <input v-model="gender" value="1" id="male" name="gender" type="radio">
                            <label for="male" class="ml-2">Nam</label>
                        </div>

                        <div class="flex ml-4">
                            <input v-model="gender" value="2" id="female" name="gender" type="radio">
                            <label for="female" class="ml-2">Nữ</label>
                        </div>
                    </div>

                    <div class="h-[50px] w-full mt-4">
                        <input 
                            v-model="email"
                            class="h-full w-full md:w-[80%] focus:outline-none border-b" 
                            placeholder="Email" type="text">
                    </div>

                    <div class="h-[50px] w-full mt-4">
                        <input 
                            v-model="password"
                            class="h-full w-full md:w-[80%] focus:outline-none border-b" 
                            placeholder="Password" type="password">
                    </div>

                    <div class="h-[50px] w-full mt-4">
                        <input 
                            v-model="password_confirmation"
                            class="h-full w-full md:w-[80%] focus:outline-none border-b" 
                            placeholder="Nhập lại password" 
                            type="password">
                    </div>
                

                    <div class="flex items-center h-[50px] mt-4">
                        <button class="h-full px-10 bg-slate-300 rounded-md">Đăng ký</button>
                        <div>
                            <span class="ml-4">Đã có tài khoản? 
                                <NuxtLink 
                                    to="/auth/login" 
                                    class="text-[#ff4d4d]"
                                >
                                    Đăng nhập
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