<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { $t } from '@/locales';
import { fetchAdd, fetchEdit, fetchGetOperateInitData } from '@/service/api/finance/account_subject';
import { useTool } from '@/hooks/common/tool';
import { menuTypeOptions } from '@/constants/business';
const { assignMatchingProperties } = useTool();
defineOptions({
  name: 'OperateDrawer'
});
interface Emits {
  (e: 'submitted'): void;
}
interface Props {
  /** the type of operation */
  operateType: NaiveUI.TableOperateType;
  /** the edit row data */
  rowData?: Finance.AccountSubject.Item | null;
}

type Model = Omit<Finance.AccountSubject.Form, keyof Api.Common.CommonRecord>;
type RuleKey = Extract<
  keyof Model,
  | 'pid'
  | 'level'
  | 'code'
  | 'cn_name'
  | 'type'
  | 'format'
  | 'currency'
  | 'com_id'
  | 'is_foreign'
  | 'is_dn'
  | 'is_frozen'
  | 'is_last'
  | 'is_cash'
  | 'balance'
  | 'foreign_balance'
  | 'opening_balance'
  | 'opening_foreign_balance'
  | 'year_opening_balance'
  | 'year_opening_foreign_balance'
  | 'vendor_required'
  | 'clerk_required'
  | 'team_required'
  | 'branch_required'
>;
const props = defineProps<Props>();
const emit = defineEmits<Emits>();
const { formRef, validate, restoreValidation } = useNaiveForm();
const { defaultRequiredRule } = useFormRules();
const initData = reactive({});
const model: Model = reactive(createDefaultModel());
const visible = defineModel<boolean>('visible', {
  default: false
});
const rules: Record<RuleKey, App.Global.FormRule> = {
  pid: defaultRequiredRule,
  level: defaultRequiredRule,
  code: defaultRequiredRule,
  cn_name: defaultRequiredRule,
  type: defaultRequiredRule,
  format: defaultRequiredRule,
  currency: defaultRequiredRule,
  com_id: defaultRequiredRule,
  is_foreign: defaultRequiredRule,
  is_dn: defaultRequiredRule,
  is_frozen: defaultRequiredRule,
  is_last: defaultRequiredRule,
  is_cash: defaultRequiredRule,
  balance: defaultRequiredRule,
  foreign_balance: defaultRequiredRule,
  opening_balance: defaultRequiredRule,
  opening_foreign_balance: defaultRequiredRule,
  year_opening_balance: defaultRequiredRule,
  year_opening_foreign_balance: defaultRequiredRule,
  vendor_required: defaultRequiredRule,
  clerk_required: defaultRequiredRule,
  team_required: defaultRequiredRule,
  branch_required: defaultRequiredRule
};
const title = computed(() => {
  const titles: Record<NaiveUI.TableOperateType, string> = {
    add: $t('page.finance.AccountSubject.add'),
    edit: $t('page.finance.AccountSubject.edit')
  };
  return titles[props.operateType];
});

/** 创建表单数据 */
function createDefaultModel(): Model {
  return {
    pid: '',
    level: '',
    code: '',
    abb: '',
    cn_name: '',
    en_name: '',
    type: '',
    format: '',
    currency: '',
    com_id: '',
    is_foreign: '',
    is_dn: '',
    is_frozen: '',
    is_last: '',
    is_cash: '',
    balance: '',
    foreign_balance: '',
    opening_balance: '',
    opening_foreign_balance: '',
    year_opening_balance: '',
    year_opening_foreign_balance: '',
    vendor_required: '',
    clerk_required: '',
    team_required: '',
    branch_required: ''
  };
}

function handleInitModel() {
  Object.assign(model, createDefaultModel());
  if (props.operateType === 'edit' && props.rowData) {
    assignMatchingProperties(props.rowData, model);
  }
}

async function getOperateInitData() {
  const { data, error } = await fetchGetOperateInitData();
  if (!error) {
    Object.assign(initData, data);
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
    await getOperateInitData();
    handleInitModel();
    restoreValidation();
  }
});
</script>

<template>
  <NModal v-model:show="visible" :title="title" preset="card" class="w-90%">
    <NScrollbar class="h-480px pr-20px">
      <NForm ref="formRef" :model="model" :rules="rules">
        <NGrid responsive="screen" item-responsive x-gap="12">
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.level')" path="level">
            <NInput v-model:value="model.level" :placeholder="$t('page.finance.AccountSubject.form.level')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.code')" path="code">
            <NInput v-model:value="model.code" :placeholder="$t('page.finance.AccountSubject.form.code')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.abb')" path="abb">
            <NInput v-model:value="model.abb" :placeholder="$t('page.finance.AccountSubject.form.abb')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.cn_name')" path="cn_name">
            <NInput v-model:value="model.cn_name" :placeholder="$t('page.finance.AccountSubject.form.cn_name')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.en_name')" path="en_name">
            <NInput v-model:value="model.en_name" :placeholder="$t('page.finance.AccountSubject.form.en_name')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.type')" path="type">
            <NInput v-model:value="model.type" :placeholder="$t('page.finance.AccountSubject.form.type')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.format')" path="format">
            <NInput v-model:value="model.format" :placeholder="$t('page.finance.AccountSubject.form.format')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.currency')" path="currency">
            <NInput v-model:value="model.currency" :placeholder="$t('page.finance.AccountSubject.form.currency')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.com_id')" path="com_id">
            <NInput v-model:value="model.com_id" :placeholder="$t('page.finance.AccountSubject.form.com_id')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_foreign')" path="is_foreign">
            <NSwitch v-model:value="model.is_foreign" checked-value="Y" unchecked-value="N"></NSwitch>
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_foreign')" path="is_foreign">
            <NInput v-model:value="model.is_foreign" :placeholder="$t('page.finance.AccountSubject.form.is_foreign')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_dn')" path="is_dn">
            <NSwitch v-model:value="model.is_dn" checked-value="Y" unchecked-value="N"></NSwitch>
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_dn')" path="is_dn">
            <NInput v-model:value="model.is_dn" :placeholder="$t('page.finance.AccountSubject.form.is_dn')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_frozen')" path="is_frozen">
            <NSwitch v-model:value="model.is_frozen" checked-value="Y" unchecked-value="N"></NSwitch>
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_frozen')" path="is_frozen">
            <NInput v-model:value="model.is_frozen" :placeholder="$t('page.finance.AccountSubject.form.is_frozen')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_last')" path="is_last">
            <NSwitch v-model:value="model.is_last" checked-value="Y" unchecked-value="N"></NSwitch>
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_last')" path="is_last">
            <NInput v-model:value="model.is_last" :placeholder="$t('page.finance.AccountSubject.form.is_last')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_cash')" path="is_cash">
            <NSwitch v-model:value="model.is_cash" checked-value="Y" unchecked-value="N"></NSwitch>
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.is_cash')" path="is_cash">
            <NInput v-model:value="model.is_cash" :placeholder="$t('page.finance.AccountSubject.form.is_cash')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.balance')" path="balance">
            <NInput v-model:value="model.balance" :placeholder="$t('page.finance.AccountSubject.form.balance')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.foreign_balance')" path="foreign_balance">
            <NInput
              v-model:value="model.foreign_balance"
              :placeholder="$t('page.finance.AccountSubject.form.foreign_balance')"
            />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.opening_balance')" path="opening_balance">
            <NInput
              v-model:value="model.opening_balance"
              :placeholder="$t('page.finance.AccountSubject.form.opening_balance')"
            />
          </NFormItemGi>
          <NFormItemGi
            span="24 m:12"
            :label="$t('page.finance.AccountSubject.opening_foreign_balance')"
            path="opening_foreign_balance"
          >
            <NInput
              v-model:value="model.opening_foreign_balance"
              :placeholder="$t('page.finance.AccountSubject.form.opening_foreign_balance')"
            />
          </NFormItemGi>
          <NFormItemGi
            span="24 m:12"
            :label="$t('page.finance.AccountSubject.year_opening_balance')"
            path="year_opening_balance"
          >
            <NInput
              v-model:value="model.year_opening_balance"
              :placeholder="$t('page.finance.AccountSubject.form.year_opening_balance')"
            />
          </NFormItemGi>
          <NFormItemGi
            span="24 m:12"
            :label="$t('page.finance.AccountSubject.year_opening_foreign_balance')"
            path="year_opening_foreign_balance"
          >
            <NInput
              v-model:value="model.year_opening_foreign_balance"
              :placeholder="$t('page.finance.AccountSubject.form.year_opening_foreign_balance')"
            />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.vendor_required')" path="vendor_required">
            <NInput
              v-model:value="model.vendor_required"
              :placeholder="$t('page.finance.AccountSubject.form.vendor_required')"
            />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.clerk_required')" path="clerk_required">
            <NInput
              v-model:value="model.clerk_required"
              :placeholder="$t('page.finance.AccountSubject.form.clerk_required')"
            />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.team_required')" path="team_required">
            <NInput
              v-model:value="model.team_required"
              :placeholder="$t('page.finance.AccountSubject.form.team_required')"
            />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.finance.AccountSubject.branch_required')" path="branch_required">
            <NInput
              v-model:value="model.branch_required"
              :placeholder="$t('page.finance.AccountSubject.form.branch_required')"
            />
          </NFormItemGi>
        </NGrid>
      </NForm>
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
