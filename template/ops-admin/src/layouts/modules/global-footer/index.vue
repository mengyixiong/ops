<script setup lang="ts">
import { ref }        from 'vue';
import { useBoolean } from "~/packages/hooks";
import OperateDrawer from './components/operate-drawer.vue';

defineOptions({
  name: 'GlobalFooter'
});
const isFlashing = ref(false);

function toggleFlash() {
  isFlashing.value = !isFlashing.value;
  console.log(isFlashing.value);
}

const { bool: showChat } = useBoolean();
function openChatDraw(){
  showChat.value = true;
}
</script>

<template>
  <DarkModeContainer class="h-full flex">
    <div class="cursor-pointer" :class="{ 'icon-flash': isFlashing }" @click="openChatDraw">
      <SvgIcon icon="ant-design:wechat-filled" class="font-size-20px color-sky-400"></SvgIcon>
    </div>
    <!--    <NButton @click="toggleFlash">测试</NButton>-->
  </DarkModeContainer>

  <OperateDrawer
    v-model:visible="showChat"
  ></OperateDrawer>
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
