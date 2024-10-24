<script setup lang="tsx">
import {  reactive, ref, watch } from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { $t } from '@/locales';
import {fetchEdit, fetchGetAllMenus, fetchGetAllMenusAndPermissions} from '@/service/api/system/menu';
import CustomTree from "@/views/setting/system/role/modules/custom-tree.vue";

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

const { formRef, validate, restoreValidation } = useNaiveForm();

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
}

/** 表单规则 */
const { defaultRequiredRule } = useFormRules();
type RuleKey = Extract<keyof Model, 'menuName' | 'status' | 'routeName' | 'routePath'>;
const rules: Record<RuleKey, App.Global.FormRule> = {
  menuName: defaultRequiredRule,
  status: defaultRequiredRule,
  routeName: defaultRequiredRule,
  routePath: defaultRequiredRule
};

/** 所有菜单选项 */
const menuOptions = ref<CommonType.Option<string>[]>([]);
async function getMenuOptions() {
  const { error, data } = await fetchGetAllMenusAndPermissions();

  if (!error) {
    menuOptions.value = data;
  }
}

async function handleSubmit() {
  await validate();

  const { error } = await fetchEdit(props.rowData.id, model);

  if (!error) {
    window.$message?.success($t(isEdit ? 'common.updateSuccess' : 'common.addSuccess'));
    closeDrawer();
    emit('submitted');
  }
}

watch(visible, () => {
  if (visible.value) {
    handleInitModel();
    restoreValidation();
    getMenuOptions();
  }
});
</script>

<template>
  <NModal v-model:show="visible" :title="$t('page.manage.role.assignPermissions')" preset="card" class="w-60%">
    <NScrollbar class="h-480px pr-20px">
      <CustomTree
        :data="menuOptions"
      ></CustomTree>
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
