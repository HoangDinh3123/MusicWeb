<script setup>
    const alertStore = useAlertStore()
    const alertMessage = computed(() => alertStore.alertMessage);
    const showAlert = computed(() => alertStore.showAlert);
    const status = computed(() => alertStore.status);
</script>

<template>
  <transition name="slide-fade">
    <div 
        :class="{'translate-x-full': !showAlert, 
                'border-l-[#00bfff]': !status
                }"
        class="fixed z-[10000] top-[10px] right-0 bg-[#e6fffa] border-l-[4px] border-l-[#ff0000] rounded-r-md text-[#234e52] p-[10px] ease-out delay-200 duration-300"
    >
      <div class="flex">
        <div class="py-1">
          <!-- Thêm biểu tượng nếu cần -->
        </div>
        <div>
          <p class="font-bold">Thông báo</p>
          <p class="text-sm">{{ alertMessage }}</p>
        </div>
      </div>
    </div>
  </transition>
</template>
  
<style scoped>
  .slide-fade-enter-active, .slide-fade-leave-active {
    transition: all 0.5s ease;
  }
  .slide-fade-enter, .slide-fade-leave-to {
    transform: translateX(100%);
    opacity: 0;
  }
</style>