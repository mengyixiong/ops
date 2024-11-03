<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { $t } from '@/locales';
import { fetchAdd, fetchEdit, fetchInitData } from '@/service/api/finance/currency_rate';
import { useTool } from '@/hooks/common/tool';
import OpsSwitch from '@/components/custom/ops-switch.vue';
import { useFinanceBasicDataStore } from '@/store/modules/finance/basic-data';
import TextSelect from '@/views/finance/basic-data/currency-rate/components/text-select.vue';
const financeBasicDataStore = useFinanceBasicDataStore();
const { assignMatchingProperties } = useTool();
defineOptions({
  name: 'OperateDrawer'
});

interface Props {
  /** the type of operation */
  operateType: NaiveUI.TableOperateType;
  /** the edit row data */
  rowData?: Finance.CurrencyRate.Item | null;
}

const props = defineProps<Props>();
const initData = reactive({
  currencyOptions: []
});

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
    add: $t('page.finance.CurrencyRate.add'),
    edit: $t('page.finance.CurrencyRate.edit')
  };
  return titles[props.operateType];
});

// 提交的模型
type Model = Omit<Finance.CurrencyRate.Form, keyof Api.Common.CommonRecord>;
const model: Model = reactive(createDefaultModel());

/** 创建表单数据 */
function createDefaultModel(): Model {
  return {
    code: '',
    rate: '',
    effective_date: null,
    type: 'settlement',
    is_enable: 'Y',
    remark: ''
  };
}

// 验证规则
type RuleKey = Extract<keyof Model, 'code' | 'com_id' | 'rate' | 'effective_date' | 'type' | 'is_enable' | 'remark'>;
const rules: Record<RuleKey, App.Global.FormRule> = {
  code: defaultRequiredRule,
  rate: defaultRequiredRule,
  effective_date: defaultRequiredRule,
  type: defaultRequiredRule
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
watch(visible, async () => {
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
        <NFormItem :label="$t('page.finance.CurrencyRate.code')" path="code">
          <NSelect
            v-model:value="model.code"
            :fallback-option="value => ({ label: value, value: '' })"
            :disabled="model.is_foreign == 'N'"
            :placeholder="$t('page.finance.CurrencyRate.form.code')"
            :options="financeBasicDataStore.currencyOptions"
            filterable
            clearable
            clear-filter-after-select
          />
        </NFormItem>
        <NFormItem :label="$t('page.finance.CurrencyRate.rate')" path="rate">
          <NInput v-model:value="model.rate" :placeholder="$t('page.finance.CurrencyRate.form.rate')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.CurrencyRate.effective_date')" path="effective_date">
          <NDatePicker
            v-model:formatted-value="model.effective_date"
            value-format="yyyy-MM-dd"
            type="date"
            :placeholder="$t('page.finance.CurrencyRate.form.effective_date')"
          />
        </NFormItem>
        <NFormItem :label="$t('page.finance.CurrencyRate.type')" path="type">
          <NSelect
            v-model:value="model.type"
            :placeholder="$t('page.finance.CurrencyRate.form.type')"
            :options="financeBasicDataStore.rateTypeOptions"
            filterable
            clearable
          />
        </NFormItem>
        <NFormItem :label="$t('page.finance.CurrencyRate.is_enable')" path="is_enable">
          <OpsSwitch v-model:value="model.is_enable"></OpsSwitch>
        </NFormItem>
        <NFormItem :label="$t('page.finance.CurrencyRate.remark')" path="remark">
          <NInput
            v-model:value="model.remark"
            type="textarea"
            :placeholder="$t('page.finance.CurrencyRate.form.remark')"
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
