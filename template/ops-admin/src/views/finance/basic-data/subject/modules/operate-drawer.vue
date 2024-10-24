<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { $t } from '@/locales';
import { fetchAdd, fetchEdit } from '@/service/api/system/role';

defineOptions({
  name: 'OperateDrawer'
});

interface Props {
  /** the type of operation */
  operateType: NaiveUI.TableOperateType;
  /** the edit row data */
  rowData?: Setting.SystemRole.Role | null;
}

const props = defineProps<Props>();

interface Emits {
  (e: 'submitted'): void;
}

const emit = defineEmits<Emits>();

const visible = defineModel<boolean>('visible', {
  default: false
});

const { formRef, validate, restoreValidation } = useNaiveForm();
const { defaultRequiredRule } = useFormRules();

const title = computed(() => {
  const titles: Record<NaiveUI.TableOperateType, string> = {
    add: $t('page.manage.role.add'),
    edit: $t('page.manage.role.edit')
  };
  return titles[props.operateType];
});

// 提交的模型
type Model = Setting.SystemCompany.Form;
const model: Model = reactive(createDefaultModel());

/** 创建表单数据 */
function createDefaultModel(): Model {
  return {
    name: '',
    code: '',
    is_default: ''
  };
}

// 验证规则
type RuleKey = Extract<keyof Model, 'name' | 'is_default'>;
const rules: Record<RuleKey, App.Global.FormRule> = {
  name: defaultRequiredRule,
  code: defaultRequiredRule
};

function handleInitModel() {
  Object.assign(model, createDefaultModel());
  if (props.operateType === 'edit' && props.rowData) {
    Object.assign(model, props.rowData);
  }
}

function closeDrawer() {
  visible.value = false;
}

/** 提交 */
async function handleSubmit() {
  await validate();
  const isEdit: boolean = props.operateType === 'edit';
  let result;
  if (isEdit) {
    result = await fetchEdit(props.rowData.id, model);
  } else {
    result = await fetchAdd(model);
  }
  if (!result?.error) {
    window.$message?.success($t(isEdit ? 'common.updateSuccess' : 'common.addSuccess'));
    closeDrawer();
    emit('submitted');
  }
}

/** 监听 visible 改变 */
watch(visible, () => {
  if (visible.value) {
    handleInitModel();
    restoreValidation();
  }
});
</script>

<template>
  <NDrawer v-model:show="visible" display-directive="show" :width="360">
    <NDrawerContent :title="title" :native-scrollbar="false" closable>
      <NForm ref="formRef" :model="model" :rules="rules">
        <NFormItem :label="$t('page.manage.role.name')" path="name">
          <NInput v-model:value="model.name" :placeholder="$t('page.manage.role.form.name')" />
        </NFormItem>
        <NFormItem :label="$t('page.manage.role.code')" path="code">
          <NInput v-model:value="model.code" :placeholder="$t('page.manage.role.form.code')" />
        </NFormItem>
        <NFormItem :label="$t('page.manage.role.description')" path="description">
          <NInput
            v-model:value="model.description"
            type="textarea"
            :placeholder="$t('page.manage.role.form.description')"
          />
        </NFormItem>
      </NForm>
      <template #footer>
        <NSpace :size="16">
          <NButton @click="closeDrawer">{{ $t('common.cancel') }}</NButton>
          <NButton type="primary" @click="handleSubmit">{{ $t('common.confirm') }}</NButton>
        </NSpace>
      </template>
    </NDrawerContent>
  </NDrawer>
</template>

<style scoped></style>
