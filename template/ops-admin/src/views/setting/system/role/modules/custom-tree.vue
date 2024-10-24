<script setup lang="ts">
import { ref } from 'vue';
defineOptions({
  name: 'CustomTree'
});

interface Props {
  data: MenuTree;
}
const props = defineProps<Props>();
const pattern = ref('');
</script>

<template>
  <NSpace vertical :size="12">
    <NInput v-model:value="pattern" placeholder="搜索" />
    <NTree
      :show-irrelevant-nodes="false"
      :pattern="pattern"
      block-line
      :data="props.data"
      expand-on-click
      checkable
      cascade
      default-expand-all
      key-field="id"
      label-field="title"
    />
  </NSpace>
</template>

<style scoped>

</style>
