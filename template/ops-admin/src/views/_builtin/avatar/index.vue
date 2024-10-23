<script setup lang="ts">
defineOptions({
  name: 'AvatarImg'
});

interface Props {
  /** the type of operation */
  width: number;
  /** the edit row data */
  src: string;
}

defineProps<Props>();
</script>

<template>
  <div>
    <NImage :style="{ height: width + 'px' }" class="image" :width="width" :src="src" />
  </div>
</template>

<style scoped>
.image {
  border-radius: 50%;
}
</style>
