<script setup lang="ts">
import { computed, reactive, watch } from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { $t } from '@/locales';
import { fetchAdd, fetchEdit, fetchGetOperateInitData } from '@/service/api/finance/account_subject';
import { useTool } from '@/hooks/common/tool';
import OpsCheckbox from '@/components/common/ops-checkbox.vue';

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
const model: Model = reactive({});
const visible = defineModel<boolean>('visible', {
  default: false
});
const rules: Record<RuleKey, App.Global.FormRule> = {
  pid: defaultRequiredRule,
  code: defaultRequiredRule,
  cn_name: defaultRequiredRule
};
const title = computed(() => {
  const titles: Record<NaiveUI.TableOperateType, string> = {
    add: $t('page.finance.AccountSubject.add'),
    edit: $t('page.finance.AccountSubject.edit')
  };
  return titles[props.operateType];
});

function handleInitModel() {
  if (props.operateType === 'add') {
    Object.assign(model, props.rowData);
  } else {
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

const btnSize = 'tiny';
</script>

<template>
  <NModal v-model:show="visible" :title="title" preset="card" class="w-40%">
    <NScrollbar class="h-480px pr-20px">
      <NForm ref="formRef" label-placement="left" :model="model" :rules="rules" label-width="120">
        <NGrid responsive="screen" item-responsive x-gap="12">
          <NFormItemGi span="24" :label="$t('page.finance.AccountSubject.type')" path="type">
            <NGrid :x-gap="12" :cols="3">
              <NGridItem>
                <NButton type="info" :size="btnSize">
                  {{ initData.typeMap?.[model.type] }}
                </NButton>
              </NGridItem>
              <NGridItem>
                <NButton type="success" :size="btnSize">{{ model.level }} 级</NButton>
              </NGridItem>
              <NGridItem>
                <OpsCheckbox v-model:checked="model.is_frozen">
                  {{ $t('page.finance.AccountSubject.is_frozen') }}
                </OpsCheckbox>
              </NGridItem>
            </NGrid>
          </NFormItemGi>

          <NFormItemGi span="24" :label="$t('page.finance.AccountSubject.is_dn')" path="is_dn">
            <NButton :size="btnSize" :type="model.is_dn == 'Y' ? 'success' : 'error'">
              {{ model.is_dn == 'Y' ? '借方' : '贷方' }}
            </NButton>
          </NFormItemGi>

          <NFormItemGi span="24" :label="$t('page.finance.AccountSubject.code')" path="code">
            <NInput v-model:value="model.code" :placeholder="$t('page.finance.AccountSubject.form.code')" />
          </NFormItemGi>
          <NFormItemGi span="24" :label="$t('page.finance.AccountSubject.abb')" path="abb">
            <NInput v-model:value="model.abb" :placeholder="$t('page.finance.AccountSubject.form.abb')" />
          </NFormItemGi>
          <NFormItemGi span="24" :label="$t('page.finance.AccountSubject.cn_name')" path="cn_name">
            <NInput v-model:value="model.cn_name" :placeholder="$t('page.finance.AccountSubject.form.cn_name')" />
          </NFormItemGi>
          <NFormItemGi span="24" :label="$t('page.finance.AccountSubject.en_name')" path="en_name">
            <NInput v-model:value="model.en_name" :placeholder="$t('page.finance.AccountSubject.form.en_name')" />
          </NFormItemGi>

          <NFormItemGi span="24" :label="$t('page.finance.AccountSubject.currency')" path="currency">
            <template #label>
              <OpsCheckbox v-model:checked="model.is_foreign">
                {{ $t('page.finance.AccountSubject.is_foreign') }}
              </OpsCheckbox>
            </template>
            <NSelect
              v-model:value="model.currency"
              :disabled="model.is_foreign == 'N'"
              :placeholder="$t('page.finance.AccountSubject.form.currency')"
              :options="initData?.currencyOptions"
              filterable
              clearable
            />
          </NFormItemGi>
          <NFormItemGi span="24" :label="$t('page.finance.AccountSubject.ancillary_accounting')">
            <NGrid :cols="4">
              <NGridItem>
                <OpsCheckbox v-model:checked="model.vendor_required">
                  {{ $t('page.finance.AccountSubject.vendor_required') }}
                </OpsCheckbox>
              </NGridItem>
              <NGridItem>
                <OpsCheckbox v-model:checked="model.clerk_required">
                  {{ $t('page.finance.AccountSubject.clerk_required') }}
                </OpsCheckbox>
              </NGridItem>
              <NGridItem>
                <OpsCheckbox v-model:checked="model.team_required">
                  {{ $t('page.finance.AccountSubject.team_required') }}
                </OpsCheckbox>
              </NGridItem>
              <NGridItem>
                <OpsCheckbox v-model:checked="model.branch_required">
                  {{ $t('page.finance.AccountSubject.branch_required') }}
                </OpsCheckbox>
              </NGridItem>
            </NGrid>
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
