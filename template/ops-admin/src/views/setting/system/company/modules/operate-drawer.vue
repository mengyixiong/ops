<script setup lang="ts">
import { computed, reactive, ref, watch } from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { fetchGetAllRoles } from '@/service/api';
import { $t } from '@/locales';
import { YesOrNoOptions, enableStatusOptions } from '@/constants/business';
import { fetchAdd, fetchEdit } from '@/service/api/system/company';
import Form = Setting.SystemCompany.Form;

defineOptions({
  name: 'OperateDrawer'
});

interface Props {
  /** the type of operation */
  operateType: NaiveUI.TableOperateType;
  /** the edit row data */
  rowData?: Setting.SystemCompany.Company | null;
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
    add: $t('page.manage.company.add'),
    edit: $t('page.manage.company.edit')
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
    abb: '',
    is_default: ''
  };
}

// 验证规则
type RuleKey = Extract<keyof Model, 'name' | 'is_default'>;
const rules: Record<RuleKey, App.Global.FormRule> = {
  name: defaultRequiredRule,
  is_default: defaultRequiredRule
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

/**
 * 监听 visible 改变
 */
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
        <NFormItem :label="$t('page.manage.company.name')" path="name">
          <NInput v-model:value="model.name" :placeholder="$t('page.manage.company.form.name')" />
        </NFormItem>
        <NFormItem :label="$t('page.manage.company.abb')" path="abb">
          <NInput v-model:value="model.abb" :placeholder="$t('page.manage.company.form.abb')" />
        </NFormItem>
        <NFormItem :label="$t('page.manage.company.is_default')" path="is_default">
          <NRadioGroup v-model:value="model.is_default">
            <NRadio v-for="item in YesOrNoOptions" :key="item.value" :value="item.value" :label="$t(item.label)" />
          </NRadioGroup>
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
