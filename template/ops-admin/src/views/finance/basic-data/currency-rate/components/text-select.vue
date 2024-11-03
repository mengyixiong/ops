<script setup lang="ts">
import { nextTick, ref, watch } from 'vue';
import { useBoolean } from '~/packages/hooks';

defineOptions({
  name: 'TextSelect'
});

type CheckboxProps = {
  options?: array<{ label: string; value: string }>;
  placeholder?: string;
};

const selectRef = ref(null);
const props = withDefaults(defineProps<CheckboxProps>(), {
  options: [], // 设置默认值
  placeholder: '请选择' // 设置默认值
});

const value = defineModel<string>('value', {
  value: 'N'
});

const showText = defineModel<string>('showText', {
  value: '222222'
});

const { bool: showSelect, setTrue, setFalse } = useBoolean();

// 监听 showSelect 状态，如果为 true，则聚焦 select
watch(showSelect, () => {
  if (showSelect.value) {
    nextTick(() => {
      selectRef.value?.focus();
    });
  }
});
function onSelectChange(v) {
  const selected = props.options.find(option => option.value === v);
  showText.value = selected ? selected.label : '';
}
function test(value) {
  return {
    label: value,
    value:''
  }
}
</script>

<template>
<!--  <NInput v-if="!showSelect" v-model:value="showText" @click="setTrue"></NInput>-->
  <NSelect
    :fallback-option="value => ({ label: value , value: '' })"
    ref="selectRef"
    v-model:value="showText"
    show-on-focus
    :placeholder="props.placeholder"
    :options="props.options"
    filterable
    clearable
    @blur="setFalse"
    @update:value="onSelectChange"
  >
  </NSelect>
</template>

<style scoped></style>
