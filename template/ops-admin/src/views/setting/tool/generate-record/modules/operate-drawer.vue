<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { $t } from '@/locales';
import { fetchAdd, fetchEdit } from '@/service/api/tool/generate_record';
import { useTool } from '@/hooks/common/tool';
const { assignMatchingProperties } = useTool();
defineOptions({
  name: 'OperateDrawer'
});

interface Props {
  /** the type of operation */
  operateType: NaiveUI.TableOperateType;
  /** the edit row data */
  rowData?: Tool.GenerateRecord.Item | null;
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
    add: $t('page.tool.GenerateRecord.add'),
    edit: $t('page.tool.GenerateRecord.edit')
  };
  return titles[props.operateType];
});

// 提交的模型
type Model = Omit<Tool.GenerateRecord.Form, keyof Api.Common.CommonRecord>;
const model: Model = reactive(createDefaultModel());

/** 创建表单数据 */
function createDefaultModel(): Model {
  return {
    module: '',
    path: '',
    front_path: '',
    table_name: '',
    prefix: ''
  };
}

// 验证规则
type RuleKey = Extract<keyof Model, 'module' | 'path' | 'front_path' | 'table_name' | 'prefix'>;
const rules: Record<RuleKey, App.Global.FormRule> = {
  module: defaultRequiredRule,
  path: defaultRequiredRule,
  front_path: defaultRequiredRule,
  table_name: defaultRequiredRule,
};

function handleInitModel() {
  Object.assign(model, createDefaultModel());
  if (props.operateType === 'edit' && props.rowData) {
    assignMatchingProperties(props.rowData, model);
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
        <NFormItem :label="$t('page.tool.GenerateRecord.table_name')" path="table_name">
          <NInput v-model:value="model.table_name" :placeholder="$t('page.tool.GenerateRecord.form.table_name')" />
        </NFormItem>
        <NFormItem :label="$t('page.tool.GenerateRecord.module')" path="module">
          <NInput v-model:value="model.module" :placeholder="$t('page.tool.GenerateRecord.form.module')" />
        </NFormItem>
        <NFormItem :label="$t('page.tool.GenerateRecord.path')" path="path">
          <NInput v-model:value="model.path" :placeholder="$t('page.tool.GenerateRecord.form.path')" />
        </NFormItem>
        <NFormItem :label="$t('page.tool.GenerateRecord.front_path')" path="front_path">
          <NInput v-model:value="model.front_path" :placeholder="$t('page.tool.GenerateRecord.form.front_path')" />
        </NFormItem>
        <NFormItem :label="$t('page.tool.GenerateRecord.prefix')" path="prefix">
          <NInput v-model:value="model.prefix" :placeholder="$t('page.tool.GenerateRecord.form.prefix')" />
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
