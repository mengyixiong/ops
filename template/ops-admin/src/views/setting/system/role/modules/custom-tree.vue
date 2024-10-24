<script setup lang="ts">
import { ref, watch } from 'vue';

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


const pattern = ref('');
const showLine = ref(false);
const isAll = ref(false);

function getAllIds(tree) {
  const ids = [];

  function traverse(node) {
    ids.push(node.id); // 获取当前节点的 id

    // 如果有子节点，递归遍历子节点
    if (node.children && node.children.length > 0) {
      node.children.forEach(child => traverse(child));
    }
  }

  // 遍历树的每一个根节点
  tree.forEach(node => traverse(node));

  return ids;
}
const checked = ref<number[]>([]);
watch(isAll, () => {
  if (isAll.value) {
    checked.value = getAllIds(props.data);
    console.log(props.data)
  } else {
    checked.value = [];
  }
});

const test = (keys) => {
  console.log(keys)
}
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
      :checked-keys="checked"
      :show-irrelevant-nodes="false"
      :pattern="pattern"
      block-line
      :data="props.data"
      expand-on-click
      checkable
      cascade
      :show-line="showLine"
      :default-expand-all="isExpandAll"
      key-field="id"
      label-field="title"
    />
  </NSpace>
</template>

<style scoped></style>
