<script setup lang="ts">
import { computed, reactive, watch }  from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { $t }                         from '@/locales';
import { fetchAdd, fetchEdit }        from '@/service/api/finance/account_subject';
import {useTool}                      from "@/hooks/common/tool";
import { menuTypeOptions }            from "@/constants/business";
import IconSelector                   from "@/views/setting/system/menu/modules/icon-selector.vue";
const {assignMatchingProperties} = useTool()
defineOptions({
  name: 'OperateDrawer'
});

interface Props {
  /** the type of operation */
  operateType: NaiveUI.TableOperateType;
  /** the edit row data */
  rowData?: Finance.AccountSubject.Item | null;
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
    add: $t('page.finance.AccountSubject.add'),
    edit: $t('page.finance.AccountSubject.edit')
  };
  return titles[props.operateType];
});

// 提交的模型
type Model = Omit<Finance.AccountSubject.Form, keyof Api.Common.CommonRecord>;
const model: Model = reactive(createDefaultModel());

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
	branch_required: '',
  };
}

// 验证规则
type RuleKey = Extract<keyof Model, 'pid' | 'level' | 'code' | 'cn_name' | 'type' | 'format' | 'currency' | 'com_id' | 'is_foreign' | 'is_dn' | 'is_frozen' | 'is_last' | 'is_cash' | 'balance' | 'foreign_balance' | 'opening_balance' | 'opening_foreign_balance' | 'year_opening_balance' | 'year_opening_foreign_balance' | 'vendor_required' | 'clerk_required' | 'team_required' | 'branch_required'>;
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
  branch_required: defaultRequiredRule,
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

  <NModal v-model:show="visible" :title="title" preset="card" class="w-90%">
    <NScrollbar class="h-480px pr-20px">
      <NForm ref="formRef" :model="model" :rules="rules">
        <NFormItem :label="$t('page.finance.AccountSubject.pid')" path="pid">
          <NInput v-model:value="model.pid" :placeholder="$t('page.finance.AccountSubject.form.pid')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.level')" path="level">
          <NInput v-model:value="model.level" :placeholder="$t('page.finance.AccountSubject.form.level')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.code')" path="code">
          <NInput v-model:value="model.code" :placeholder="$t('page.finance.AccountSubject.form.code')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.abb')" path="abb">
          <NInput v-model:value="model.abb" :placeholder="$t('page.finance.AccountSubject.form.abb')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.cn_name')" path="cn_name">
          <NInput v-model:value="model.cn_name" :placeholder="$t('page.finance.AccountSubject.form.cn_name')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.en_name')" path="en_name">
          <NInput v-model:value="model.en_name" :placeholder="$t('page.finance.AccountSubject.form.en_name')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.type')" path="type">
          <NInput v-model:value="model.type" :placeholder="$t('page.finance.AccountSubject.form.type')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.format')" path="format">
          <NInput v-model:value="model.format" :placeholder="$t('page.finance.AccountSubject.form.format')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.currency')" path="currency">
          <NInput v-model:value="model.currency" :placeholder="$t('page.finance.AccountSubject.form.currency')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.com_id')" path="com_id">
          <NInput v-model:value="model.com_id" :placeholder="$t('page.finance.AccountSubject.form.com_id')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_foreign')" path="is_foreign">
          <NSwitch v-model:value="model.is_foreign" checked-value="Y" unchecked-value="N">
          </NSwitch>
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_foreign')" path="is_foreign">
          <NInput v-model:value="model.is_foreign" :placeholder="$t('page.finance.AccountSubject.form.is_foreign')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_dn')" path="is_dn">
          <NSwitch v-model:value="model.is_dn" checked-value="Y" unchecked-value="N">
          </NSwitch>
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_dn')" path="is_dn">
          <NInput v-model:value="model.is_dn" :placeholder="$t('page.finance.AccountSubject.form.is_dn')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_frozen')" path="is_frozen">
          <NSwitch v-model:value="model.is_frozen" checked-value="Y" unchecked-value="N">
          </NSwitch>
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_frozen')" path="is_frozen">
          <NInput v-model:value="model.is_frozen" :placeholder="$t('page.finance.AccountSubject.form.is_frozen')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_last')" path="is_last">
          <NSwitch v-model:value="model.is_last" checked-value="Y" unchecked-value="N">
          </NSwitch>
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_last')" path="is_last">
          <NInput v-model:value="model.is_last" :placeholder="$t('page.finance.AccountSubject.form.is_last')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_cash')" path="is_cash">
          <NSwitch v-model:value="model.is_cash" checked-value="Y" unchecked-value="N">
          </NSwitch>
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.is_cash')" path="is_cash">
          <NInput v-model:value="model.is_cash" :placeholder="$t('page.finance.AccountSubject.form.is_cash')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.balance')" path="balance">
          <NInput v-model:value="model.balance" :placeholder="$t('page.finance.AccountSubject.form.balance')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.foreign_balance')" path="foreign_balance">
          <NInput v-model:value="model.foreign_balance" :placeholder="$t('page.finance.AccountSubject.form.foreign_balance')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.opening_balance')" path="opening_balance">
          <NInput v-model:value="model.opening_balance" :placeholder="$t('page.finance.AccountSubject.form.opening_balance')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.opening_foreign_balance')" path="opening_foreign_balance">
          <NInput v-model:value="model.opening_foreign_balance" :placeholder="$t('page.finance.AccountSubject.form.opening_foreign_balance')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.year_opening_balance')" path="year_opening_balance">
          <NInput v-model:value="model.year_opening_balance" :placeholder="$t('page.finance.AccountSubject.form.year_opening_balance')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.year_opening_foreign_balance')" path="year_opening_foreign_balance">
          <NInput v-model:value="model.year_opening_foreign_balance" :placeholder="$t('page.finance.AccountSubject.form.year_opening_foreign_balance')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.vendor_required')" path="vendor_required">
          <NInput v-model:value="model.vendor_required" :placeholder="$t('page.finance.AccountSubject.form.vendor_required')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.clerk_required')" path="clerk_required">
          <NInput v-model:value="model.clerk_required" :placeholder="$t('page.finance.AccountSubject.form.clerk_required')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.team_required')" path="team_required">
          <NInput v-model:value="model.team_required" :placeholder="$t('page.finance.AccountSubject.form.team_required')" />
        </NFormItem>
        <NFormItem :label="$t('page.finance.AccountSubject.branch_required')" path="branch_required">
          <NInput v-model:value="model.branch_required" :placeholder="$t('page.finance.AccountSubject.form.branch_required')" />
        </NFormItem>
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
