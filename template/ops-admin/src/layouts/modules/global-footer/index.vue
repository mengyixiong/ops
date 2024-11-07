<script setup lang="ts">
import { ref } from 'vue';

defineOptions({
  name: 'GlobalFooter'
});
const isFlashing = ref(false);
function toggleFlash() {
  isFlashing.value = !isFlashing.value;
  console.log(isFlashing.value)
}
</script>

<template>
  <DarkModeContainer class="h-full flex">
    <div :class="{ 'icon-flash': isFlashing }">
      <SvgIcon
        icon="ant-design:wechat-filled"

        class="font-size-20px color-sky-400"
      ></SvgIcon>
    </div>
    <NButton @click="toggleFlash">测试</NButton>
  </DarkModeContainer>
</template>

<style scoped>
/* 定义闪烁动画 */
@keyframes flash {
  0%,
  100% {
    opacity: 1;
  }
  50% {
    opacity: 0;
  }
}

/* 闪烁类 */
.icon-flash {
  animation: flash 1s infinite;
}
</style>
