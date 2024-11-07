<script setup lang="ts">
import { ref, watch } from 'vue';
import { useFullscreen } from '@vueuse/core';
import { $t } from '@/locales';
import { fetchSend } from '@/service/api/chat';
import { useAuthStore } from '@/store/modules/auth';
const authStore = useAuthStore();
defineOptions({
  name: 'OperateDrawer'
});

const visible = defineModel<boolean>('visible', {
  default: false
});

const messages = ref([
  {
    type: 'sender',
    content: '这里是内容1',
    avatar: 'https://07akioni.oss-cn-beijing.aliyuncs.com/07akioni.jpeg'
  },
  {
    type: 'recipient',
    content: '这里是内容2',
    avatar: 'https://07akioni.oss-cn-beijing.aliyuncs.com/07akioni.jpeg'
  },
  {
    type: 'sender',
    content: '这里是内容3',
    avatar: 'https://07akioni.oss-cn-beijing.aliyuncs.com/07akioni.jpeg'
  },
  {
    type: 'sender',
    content: '这里是内容4',
    avatar: 'https://07akioni.oss-cn-beijing.aliyuncs.com/07akioni.jpeg'
  },
  {
    type: 'recipient',
    content: '这里是内容5',
    avatar: 'https://07akioni.oss-cn-beijing.aliyuncs.com/07akioni.jpeg'
  }
]);
const message = ref('');
const containerRef = ref(null);
const loading = ref(false);

function closeDrawer() {
  visible.value = false;
}

/** 提交 */
async  function send() {
  if (!message.value) {
    window.$message?.error('不能发送空白消息！');
    return;
  }
  loading.value = true;

  const {error} = await fetchSend();
  if (!error){
    messages.value.push({
      type: 'sender',
      content: message.value,
      avatar: authStore.userInfo.avatar
    });
    message.value = '';
  }
  loading.value = false;
}

/** 监听 visible 改变 */
watch(visible, async () => {});
</script>

<template>
  <NModal
    ref="containerRef"
    v-model:show="visible"
    :closable="false"
    preset="card"
    class="h-70vh w-60% p-0"
    :header-style="{ padding: 0, height: 0 }"
    :content-style="{ padding: 0 }"
  >
    <template #default>
      <NGrid :cols="18" class="h-70vh">
        <NGi :span="1" class="left">
          <NFlex vertical class="pt-50px">
            <div class="mb-10px flex cursor-pointer flex-justify-center pb-40px">
              <NAvatar :size="48" :src="authStore.userInfo.avatar" />
            </div>
            <div class="mb-10px flex cursor-pointer flex-justify-center">
              <SvgIcon icon="ant-design:user-outlined" class="font-size-30px color-sky-400"></SvgIcon>
            </div>
            <div class="mb-10px flex cursor-pointer flex-justify-center">
              <SvgIcon icon="ant-design:user-outlined" class="font-size-30px color-sky-400"></SvgIcon>
            </div>
            <div class="mb-10px flex cursor-pointer flex-justify-center">
              <SvgIcon icon="ant-design:user-outlined" class="font-size-30px color-sky-400"></SvgIcon>
            </div>
          </NFlex>
        </NGi>
        <NGi :span="5">
          <div>
            <NAffix class="h-5vh" position="absolute"></NAffix>
            <NScrollbar class="h-65vh bg-#dfdddd"></NScrollbar>
          </div>
        </NGi>
        <NGi :span="12">
          <div>
            <div class="h-5vh">
              <NFlex justify="space-between" class="pr-10px">
                <div class="font-size-24px line-height-5vh">我是刘卓</div>
                <div>
                  <div class="h-2.5vh flex gap-10px flex-items-center">
                    <div @click="closeDrawer">
                      <SvgIcon icon="ep:minus" class="cursor-pointer font-size-18px"></SvgIcon>
                    </div>
                    <div>
                      <SvgIcon icon="ep:full-screen" class="cursor-pointer font-size-14px"></SvgIcon>
                    </div>
                    <div @click="closeDrawer">
                      <SvgIcon icon="ep:close" class="cursor-pointer font-size-18px"></SvgIcon>
                    </div>
                  </div>
                  <div class="h-2.5vh gap-10px flex-items-end flex-items-center">
                    <div style="float: right">
                      <SvgIcon icon="ep:more" class="cursor-pointer font-size-18px"></SvgIcon>
                    </div>
                  </div>
                </div>
              </NFlex>
            </div>
            <NScrollbar class="h-50vh">
              <div
                v-for="(item, index) in messages"
                :key="index"
                class="message"
                :class="{ reverse: item.type === 'sender' }"
              >
                <img class="avatar" :src="item.avatar" alt="" />
                <span>{{ item.content }}</span>
              </div>
            </NScrollbar>
            <div class="h-15vh border-t border-t-[2px] border-#f5f5f5 border-solid">
              <div class="h-2.5vh"></div>
              <div class="h-8.5vh">
                <NInput
                  v-model:value="message"
                  :bordered="false"
                  placeholder="请输入内容"
                  class="h-8vh w-full"
                  :autosize="{ minRows: 1, maxRows: 3 }"
                  type="textarea"
                ></NInput>
              </div>
              <div class="h-4vh">
                <div style="float: right" class="pr-10px pt-8px">
                  <NButton size="small" strong secondary type="success" :loading="loading" @click="send">
                    发 送(S)
                  </NButton>
                </div>
              </div>
            </div>
          </div>
        </NGi>
      </NGrid>
    </template>
  </NModal>
</template>

<style scoped>
.left {
  background: #2e2e2e;
}
.message {
  display: flex;
  align-items: center;
  margin-bottom: 10px;
  padding: 10px;
}

.message:last-child {
  margin-bottom: 0;
}

.reverse {
  flex-direction: row-reverse;
}

.text {
  text-align: center;
}

.reverse .avatar {
  margin-left: 10px;
}

.avatar {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  margin-right: 10px;
}
</style>
