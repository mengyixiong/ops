<script setup lang="ts">
import { h, ref, watch } from 'vue';
import { useTool } from '@/hooks/common/tool';
const { extractIdsFromTree } = useTool();

defineOptions({
  name: 'CustomTree'
});

interface Props {
  data: MenuTree;
}

const props = defineProps<Props>();

const isExpandAll = defineModel<boolean>('isExpandAll', {
  default: false
});

const checked = defineModel<number[]>('checked', {
  default: []
});

const pattern = ref('');
const showLine = ref(false);
const isAll = ref(false);


watch(isAll, () => {
  if (isAll.value) {
    checked.value = extractIdsFromTree(props.data);
  } else {
    checked.value = [];
  }
});
console.log(checked)
</script>

<template>
  <NSpace vertical :size="12">
    <NFlex>
      <NSwitch v-model:value="isExpandAll">
        <template #checked>展开</template>
        <template #unchecked>收起</template>
      </NSwitch>
      <NCheckbox v-model:checked="isAll">全选</NCheckbox>
      <NSwitch v-model:value="showLine">
        <template #checked>显示连接线</template>
        <template #unchecked>隐藏连接线</template>
      </NSwitch>
    </NFlex>
    <NInput placeholder="搜索">
      <template #prefix>
        <SvgIcon icon="icon-park-outline:search" />
      </template>
    </NInput>
    <NTree
      v-model:checked-keys="checked"
      :show-irrelevant-nodes="false"
      :pattern="pattern"
      block-line
      :data="props.data"
      expand-on-click
      cascade
      checkable
      :show-line="showLine"
      :default-expand-all="isExpandAll"
      key-field="id"
      label-field="title"
    />
  </NSpace>
</template>

<style scoped></style>
