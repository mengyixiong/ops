<script setup lang="ts">
defineOptions({
  name: 'OpsCheckbox'
});

type CheckboxProps = {
  checkedValue?: string;
  uncheckedValue?: string;
};

const props = withDefaults(defineProps<CheckboxProps>(), {
  checkedValue: 'Y', // 设置默认值
  uncheckedValue: 'N' // 设置默认值
});

const value = defineModel<string>('value', {
  value: 'N'
});
</script>

<template>
  <NSwitch v-model:value="value" :checked-value="props.checkedValue" :unchecked-value="props.uncheckedValue"></NSwitch>
</template>

<style scoped></style>
