<script setup lang="ts">
import { computed, reactive, ref, watch } from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { $t } from '@/locales';
import { fetchAdd, fetchEdit } from '@/service/api/finance/voucher';
import { useTool } from '@/hooks/common/tool';
import OpsCheckbox from '@/components/common/ops-checkbox.vue';

const { assignMatchingProperties } = useTool();
defineOptions({
  name: 'OperateDrawer'
});

interface Props {
  /** the type of operation */
  operateType: NaiveUI.TableOperateType;
  /** the edit row data */
  rowData?: Finance.Voucher.Item | null;
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
    add: $t('page.finance.Voucher.add'),
    edit: $t('page.finance.Voucher.edit')
  };
  return titles[props.operateType];
});

// 提交的模型
type Model = Omit<Finance.Voucher.Form, keyof Api.Common.CommonRecord>;
const model: Model = reactive(createDefaultModel());

/** 创建表单数据 */
function createDefaultModel(): Model {
  return {
    com_id: '',
    voucher_num: '',
    billing_date: null,
    bookkeeper: '',
    auditor: '',
    audit_at: '',
    cashier: '',
    make_people: '',
    make_at: '',
    dn_total: '',
    cn_total: '',
    is_effective: '',
    is_audit: '',
    is_foreign: '',
    is_recorded: '',
    type: '',
    remarks: '',
    details: [createDetailModel(), createDetailModel(), createDetailModel(), createDetailModel(), createDetailModel()]
  };
}

function createDetailModel(): Finance.Voucher.Detail {
  return {
    ref: '',
    code: '',
    foreign: '',
    dn: '',
    cn: '',
    showPlus: false
  };
}

// 验证规则
type RuleKey = Extract<
  keyof Model,
  | 'com_id'
  | 'voucher_num'
  | 'billing_date'
  | 'bookkeeper'
  | 'make_people'
  | 'make_at'
  | 'dn_total'
  | 'cn_total'
  | 'is_effective'
  | 'is_audit'
  | 'is_foreign'
  | 'is_recorded'
  | 'type'
>;
const rules: Record<RuleKey, App.Global.FormRule> = {
  com_id: defaultRequiredRule,
  voucher_num: defaultRequiredRule,
  billing_date: defaultRequiredRule,
  bookkeeper: defaultRequiredRule,
  make_people: defaultRequiredRule,
  make_at: defaultRequiredRule,
  dn_total: defaultRequiredRule,
  cn_total: defaultRequiredRule,
  is_effective: defaultRequiredRule,
  is_audit: defaultRequiredRule,
  is_foreign: defaultRequiredRule,
  is_recorded: defaultRequiredRule,
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
watch(visible, () => {
  if (visible.value) {
    handleInitModel();
    restoreValidation();
  }
});
function test(index) {
  model.details[index].showPlus = true;
}
function test2(index) {
  model.details[index].showPlus = false;
}

function plus(index) {
  console.log(111);
  model.details.splice(index + 1, 0, { ref: '', code: '', foreign: '', dn: '', cn: '', showPlus: false });
}

function minus(index) {
  if (model.details.length <= 4) {
    return;
  }
  model.details.splice(index, 1);
}
</script>

<template>
  <!--  <NDrawer v-model:show="visible" display-directive="show" :width="360">-->
  <!--    <NDrawerContent :title="title" :native-scrollbar="false" closable>-->
  <!--      <NForm ref="formRef" :model="model" :rules="rules">-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.com_id')" path="com_id">-->
  <!--          <NInput v-model:value="model.com_id" :placeholder="$t('page.finance.Voucher.form.com_id')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.voucher_num')" path="voucher_num">-->
  <!--          <NInput v-model:value="model.voucher_num" :placeholder="$t('page.finance.Voucher.form.voucher_num')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.billing_date')" path="billing_date">-->
  <!--          <NInput v-model:value="model.billing_date" :placeholder="$t('page.finance.Voucher.form.billing_date')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.bookkeeper')" path="bookkeeper">-->
  <!--          <NInput v-model:value="model.bookkeeper" :placeholder="$t('page.finance.Voucher.form.bookkeeper')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.auditor')" path="auditor">-->
  <!--          <NInput v-model:value="model.auditor" :placeholder="$t('page.finance.Voucher.form.auditor')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.audit_at')" path="audit_at">-->
  <!--          <NInput v-model:value="model.audit_at" :placeholder="$t('page.finance.Voucher.form.audit_at')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.cashier')" path="cashier">-->
  <!--          <NInput v-model:value="model.cashier" :placeholder="$t('page.finance.Voucher.form.cashier')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.make_people')" path="make_people">-->
  <!--          <NInput v-model:value="model.make_people" :placeholder="$t('page.finance.Voucher.form.make_people')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.make_at')" path="make_at">-->
  <!--          <NInput v-model:value="model.make_at" :placeholder="$t('page.finance.Voucher.form.make_at')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.dn_total')" path="dn_total">-->
  <!--          <NInput v-model:value="model.dn_total" :placeholder="$t('page.finance.Voucher.form.dn_total')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.cn_total')" path="cn_total">-->
  <!--          <NInput v-model:value="model.cn_total" :placeholder="$t('page.finance.Voucher.form.cn_total')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.is_effective')" path="is_effective">-->
  <!--          <NSwitch v-model:value="model.is_effective" checked-value="Y" unchecked-value="N">-->
  <!--          </NSwitch>-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.is_audit')" path="is_audit">-->
  <!--          <NSwitch v-model:value="model.is_audit" checked-value="Y" unchecked-value="N">-->
  <!--          </NSwitch>-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.is_foreign')" path="is_foreign">-->
  <!--          <NSwitch v-model:value="model.is_foreign" checked-value="Y" unchecked-value="N">-->
  <!--          </NSwitch>-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.is_recorded')" path="is_recorded">-->
  <!--          <NSwitch v-model:value="model.is_recorded" checked-value="Y" unchecked-value="N">-->
  <!--          </NSwitch>-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.type')" path="type">-->
  <!--          <NInput v-model:value="model.type" :placeholder="$t('page.finance.Voucher.form.type')" />-->
  <!--        </NFormItem>-->
  <!--        <NFormItem :label="$t('page.finance.Voucher.remarks')" path="remarks">-->
  <!--          <NInput v-model:value="model.remarks" :placeholder="$t('page.finance.Voucher.form.remarks')" />-->
  <!--        </NFormItem>-->
  <!--      </NForm>-->
  <!--      <template #footer>-->
  <!--        <NSpace :size="16">-->
  <!--          <NButton @click="closeDrawer">{{ $t('common.cancel') }}</NButton>-->
  <!--          <NButton type="primary" @click="handleSubmit">{{ $t('common.confirm') }}</NButton>-->
  <!--        </NSpace>-->
  <!--      </template>-->
  <!--    </NDrawerContent>-->
  <!--  </NDrawer>-->
  <NModal v-model:show="visible" :title="title" preset="card" class="h-90vh w-70%">
    <NScrollbar class="h-1000px pr-20px">
      <NFlex justify="end">
        <OpsCheckbox v-model:checked="model.is_audit">
          {{ $t('page.finance.Voucher.is_audit') }}
        </OpsCheckbox>
        <OpsCheckbox v-model:checked="model.is_recorded">
          {{ $t('page.finance.Voucher.is_recorded') }}
        </OpsCheckbox>
        <OpsCheckbox v-model:checked="model.is_effective">
          {{ $t('page.finance.Voucher.is_effective') }}
        </OpsCheckbox>
      </NFlex>
      <NFlex justify="center" class="title">记账凭证</NFlex>

      <NFlex justify="space-between" class="mb-10px pl-25px">
        <NFlex>
          <div class="h-30px flex line-height-30px">
            <div class="h-30px w-80px">凭证号码:</div>
            <NDatePicker
              v-model:formatted-value="model.billing_date"
              size="small"
              value-format="yyyy-MM-dd"
              type="date"
              :placeholder="$t('page.finance.CurrencyRate.form.effective_date')"
            />
          </div>
          <div class="h-30px flex line-height-30px">
            <div class="h-30px w-80px">记账日期:</div>
            <NDatePicker
              v-model:formatted-value="model.billing_date"
              size="small"
              value-format="yyyy-MM-dd"
              type="date"
              :placeholder="$t('page.finance.CurrencyRate.form.effective_date')"
            />
          </div>
        </NFlex>
        <NFlex>
          <div class="h-30px flex line-height-30px">
            <div class="h-30px w-80px">附单据:</div>
            <NInput v-model:value="model.remarks" placeholder="" size="small" :bordered="false" />
          </div>
        </NFlex>
      </NFlex>
      <NFlex class="mb-10px">
        <NTable :single-line="false" class="voucher-table">
          <thead>
            <tr>
              <th class="w-10px"></th>
              <th class="w-150px">摘要</th>
              <th>明细科目</th>
              <th>外币</th>
              <th>借方金额</th>
              <th>贷方金额</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, index) in model.details" :key="index" @mouseover="test(index)" @mouseout="test2(index)">
              <td>
                <div v-show="item.showPlus">
                  <NFlex justify="space-between">
                    <div @click="plus(index)">
                      <SvgIcon class="cursor-pointer" icon="ant-design:plus-circle-twotone"></SvgIcon>
                    </div>
                    <div @click="minus(index)">
                      <SvgIcon class="cursor-pointer" icon="ant-design:minus-circle-twotone"></SvgIcon>
                    </div>
                  </NFlex>
                </div>
              </td>
              <td>
                <NInput v-model:value="item.ref" :bordered="false" placeholder="" />
              </td>
              <td>
                <NInput v-model:value="item.code" :bordered="false" placeholder="" />
              </td>
              <td>
                <NInput v-model:value="item.foreign" :bordered="false" placeholder="" />
              </td>
              <td>
                <NInput v-model:value="item.dn" :bordered="false" placeholder="" />
              </td>
              <td>
                <NInput v-model:value="item.cn" :bordered="false" placeholder="" />
              </td>
            </tr>
          </tbody>
          <tfoot>
            <tr class="h-50px">
              <td></td>
              <td colspan="2" style="padding-left: 12px">合计：</td>
              <td></td>
              <td></td>
              <td style="padding-right: 12px"></td>
            </tr>
          </tfoot>
        </NTable>
      </NFlex>
      <!-- 备注 -->
      <NFlex class="mb-10px pl-25px">
        <NInput
          v-model:value="model.remarks"
          :placeholder="$t('page.finance.Voucher.form.remarks')"
          type="textarea"
          size="small"
          :min="1"
        />
      </NFlex>
      <!--  操作人  -->
      <NFlex justify="space-between" class="pl-25px">
        <div class="h-30px flex line-height-30px">
          <div class="h-30px w-50px">记账:</div>
          <NInput v-model:value="model.remarks" placeholder="" size="small" :bordered="false" />
        </div>
        <div class="h-30px flex line-height-30px">
          <div class="h-30px w-50px">记账:</div>
          <NInput v-model:value="model.remarks" placeholder="" size="small" :bordered="false" />
        </div>
        <div class="h-30px flex line-height-30px">
          <div class="h-30px w-50px">记账:</div>
          <NInput v-model:value="model.remarks" placeholder="" size="small" :bordered="false" />
        </div>
        <div class="h-30px flex line-height-30px">
          <div class="h-30px w-50px">记账:</div>
          <NInput v-model:value="model.remarks" placeholder="" size="small" :bordered="false" />
        </div>
      </NFlex>
    </NScrollbar>
    <template #footer>
      <NSpace justify="end" :size="16">
        <NButton @click="closeDrawer">{{ $t('common.cancel') }}</NButton>
        <NButton type="primary" @click="handleSubmit">{{ $t('common.confirm') }}</NButton>
      </NSpace>
    </template>
  </NModal>
</template>

<style scoped>
.title {
  font-size: 36px;
  font-weight: 500;
  letter-spacing: 15px;
}
.voucher-table {
  border-left: none;
  border-top: none;
  border-bottom: none;
}
.voucher-table th {
  background: #fff;
  border-top: 2px solid #dcdfe6;
}
/* 隐藏第一列的右侧边框 */
.voucher-table th:first-child,
.voucher-table td:first-child {
  border-left: none;
  border-top: none;
  border-bottom: none;
}
.voucher-table tfoot {
  border-top: 2px solid #dcdfe6;
}
.voucher-table th:last-child,
.voucher-table td:last-child {
  border-right: 2px solid #dcdfe6;
}
.voucher-table th:nth-child(2),
.voucher-table td:nth-child(2) {
  border-left: 2px solid #dcdfe6;
}
.voucher-table tbody tr:last-child td:not(:first-child) {
  border-bottom: 1px solid #dcdfe6;
}
.voucher-table tfoot tr:last-child td:not(:first-child) {
  border-bottom: 2px solid #dcdfe6;
}
.voucher-table td {
  padding: 8px 0;
}
</style>
