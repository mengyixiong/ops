<script setup lang="tsx">
import { reactive, ref, watch } from 'vue';
import { useNaiveForm } from '@/hooks/common/form';
import { $t } from '@/locales';
import { fetchGetAllMenusAndPermissions } from '@/service/api/system/menu';
import { fetchAssignPermission } from '@/service/api/system/role';
import CustomTree from '@/views/setting/system/role/modules/custom-tree.vue';
import { useTool } from "@/hooks/common/tool";
const { extractIdsFromTree, findPathToNode } = useTool();


defineOptions({
  name: 'AssignPermission'
});

export type OperateType = NaiveUI.TableOperateType | 'addChild';

interface Props {
  /** the edit row data */
  rowData?: Setting.SystemRole.Role | null;
}
const props = defineProps<Props>();

/** 事件 */
interface Emits {
  (e: 'submitted'): void;
}
const emit = defineEmits<Emits>();

/** 弹窗可见性 */
const visible = defineModel<boolean>('visible', {
  default: false
});
function closeDrawer() {
  visible.value = false;
}

/** 所有菜单选项 */
const menuOptions = ref<CommonType.Option<string>[]>([]);
async function getMenuOptions() {
  const { error, data } = await fetchGetAllMenusAndPermissions();

  if (!error) {
    menuOptions.value = data;
  }
}

const { validate, restoreValidation } = useNaiveForm();

/** 模型数据 */
type Model = Setting.SystemMenu.AssignPermission;
const model: Model = reactive(createDefaultModel());
function createDefaultModel(): Model {
  return {
    menus: []
  };
}
function handleInitModel() {
  Object.assign(model, createDefaultModel());

  model.menus = props.rowData?.menus || [1];
  // 转换为字符串数组
}


async function handleSubmit() {
  await validate();

  const { error } = await fetchAssignPermission(props.rowData.id, model);

  if (!error) {
    window.$message?.success($t('page.manage.role.assignPermissionsSuccess'));
    closeDrawer();
    emit('submitted');
  }
}


watch(visible, async () => {
  if (visible.value) {
    await getMenuOptions();
    handleInitModel();
    restoreValidation();
  }
});
</script>

<template>
  <NModal v-model:show="visible" :title="$t('page.manage.role.assignPermissions')" preset="card" class="w-60%">
    <NScrollbar class="h-480px pr-20px">
      <CustomTree v-model:checked="model.menus" :data="menuOptions"></CustomTree>
    </NScrollbar>
    <template #footer>
      <NSpace justify="end" :size="16">
        <NButton @click="closeDrawer">{{ $t('common.cancel') }}</NButton>
        <NButton type="primary" @click="handleSubmit">{{ $t('common.confirm') }}</NButton>
      </NSpace>
    </template>
  </NModal>
</template>

<style scoped></style>
