<script setup lang="tsx">
import { computed, reactive, ref, watch } from 'vue';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { $t } from '@/locales';
import { menuTypeOptions } from '@/constants/business';
import { fetchAdd, fetchEdit, fetchGetAllMenus } from '@/service/api/system/menu';
import { fetchGetAllCompanies } from '@/service/api/system/company';
import { getRoutePathByRouteName } from './shared';
import IconSelector from './icon-selector.vue';

defineOptions({
  name: 'MenuOperateModal'
});

export type OperateType = NaiveUI.TableOperateType | 'addChild';

interface Props {
  /** the type of operation */
  operateType: OperateType;
  /** the edit menu data or the parent menu data when adding a child menu */
  rowData?: Setting.SystemMenu.Menu | null;
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
  const titles: Record<OperateType, string> = {
    add: $t('page.manage.menu.add'),
    addChild: $t('page.manage.menu.add'),
    edit: $t('page.manage.menu.edit')
  };
  return titles[props.operateType];
});

type Model = Setting.SystemMenu.Form;

const model: Model = reactive(createDefaultModel());

function createDefaultModel(): Model {
  return {
    com_id: [],
    type: '1',
    title: '',
    is_hide_menu: 'N',
    name: '',
    pid: 0,
    path: '',
    icon: '',
    permission: '',
    component: '',
    i18n_key: ''
  };
}

type RuleKey = Extract<keyof Model, 'menuName' | 'status' | 'routeName' | 'routePath'>;
const rules: Record<RuleKey, App.Global.FormRule> = {
  menuName: defaultRequiredRule,
  status: defaultRequiredRule,
  routeName: defaultRequiredRule,
  routePath: defaultRequiredRule
};

const disabledMenuType = computed(() => props.operateType === 'edit');

// 显示菜单相关控件和显示权限相关控件
const showMenu = computed(() => model.type === '1');
const showPermission = computed(() => model.type === '2');

/** 所有菜单选项 */
const menuOptions = ref<CommonType.Option<string>[]>([]);
async function getMenuOptions() {
  let id = 0;
  if (props.operateType === 'edit') {
    id = props.rowData?.id || 0;
  }
  const { error, data } = await fetchGetAllMenus(id);

  if (!error) {
    menuOptions.value = data;
  }
}

/** 所有主体选项 */
const companyOptions = ref<CommonType.Option<string>[]>([]);
async function getCompanyOptions() {
  const { error, data } = await fetchGetAllCompanies();

  if (!error) {
    companyOptions.value = data.map(item => {
      return {
        label: item.name,
        value: item.id
      };
    });
  }
}

function handleInitModel() {
  Object.assign(model, createDefaultModel());

  if (!props.rowData) return;

  if (props.operateType === 'addChild') {
    const { id, name, component } = props.rowData;
    Object.assign(model, { pid: id, name, component });
  }

  if (props.operateType === 'edit') {
    Object.assign(model, props.rowData);
  }
}

function closeDrawer() {
  visible.value = false;
}

function handleUpdateRoutePathByRouteName() {
  if (model.name) {
    model.path = getRoutePathByRouteName(model.name);
  } else {
    model.path = '';
  }
}

function handleUpdateI18nKeyByRouteName() {
  if (model.name) {
    model.i18n_key = `route.${model.name}` as App.I18n.I18nKey;
  } else {
    model.i18n_key = null;
  }
}

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

watch(visible, () => {
  if (visible.value) {
    handleInitModel();
    restoreValidation();
    getMenuOptions();
    getCompanyOptions();
  }
});

watch(
  () => model.name,
  () => {
    handleUpdateRoutePathByRouteName();
    handleUpdateI18nKeyByRouteName();
  }
);

const iconDraw = ref(false);
function openIconSelector() {
  console.log('openIconSelector');
  iconDraw.value = true;
}
</script>

<template>

  <NModal v-model:show="visible" :title="title" preset="card" class="w-90%">
    <NScrollbar class="h-480px pr-20px">
      <NForm ref="formRef" :model="model" :rules="rules" label-placement="left" :label-width="100">
        <NGrid responsive="screen" item-responsive>
          <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.type')" path="type">
            <NRadioGroup v-model:value="model.type" :disabled="disabledMenuType">
              <NRadio v-for="item in menuTypeOptions" :key="item.value" :value="item.value" :label="$t(item.label)" />
            </NRadioGroup>
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.pid')" path="type">
            <NTreeSelect
              v-model:value="model.pid"
              clearable
              filterable
              key-field="id"
              label-field="title"
              :options="menuOptions"
            />
          </NFormItemGi>

          <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.com_id')" path="type">
            <NSelect
              v-model:value="model.com_id"
              :placeholder="$t('page.manage.menu.com_id')"
              :options="companyOptions"
              filterable
              multiple
              clearable
            />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.title')" path="title">
            <NInput v-model:value="model.title" :placeholder="$t('page.manage.menu.form.title')" />
          </NFormItemGi>
          <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.i18n_key')" path="i18n_key">
            <NInput v-model:value="model.i18n_key" :placeholder="$t('page.manage.menu.form.i18n_key')" />
          </NFormItemGi>

          <!-- 类型为1:菜单时 需要显示 -->
          <template v-if="showMenu">
            <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.name')" path="name">
              <NInput v-model:value="model.name" :placeholder="$t('page.manage.menu.form.name')" />
            </NFormItemGi>
            <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.path')" path="path">
              <NInput v-model:value="model.path" disabled :placeholder="$t('page.manage.menu.form.path')" />
            </NFormItemGi>
            <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.component')" path="component">
              <NInput v-model:value="model.component" :placeholder="$t('page.manage.menu.form.component')" />
            </NFormItemGi>
            <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.icon')" path="icon">
              <IconSelector v-model:visible="iconDraw" v-model:icon="model.icon" />
              <NInputGroup>
                <NInput v-model:value="model.icon" :placeholder="$t('page.manage.menu.form.icon')" clearable >
                  <template #prefix>
                    <SvgIcon :icon="model.icon" ></SvgIcon>
                  </template>
                </NInput>
                <NButton type="primary" ghost @click="openIconSelector">选择图标</NButton>
              </NInputGroup>
            </NFormItemGi>
            <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.is_hide_menu')" path="is_hide_menu">
              <NRadioGroup v-model:value="model.is_hide_menu">
                <NRadio value="Y" :label="$t('common.yesOrNo.yes')" />
                <NRadio value="N" :label="$t('common.yesOrNo.no')" />
              </NRadioGroup>
            </NFormItemGi>

            <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.sort')" path="sort">
              <NInputNumber v-model:value="model.sort" clearable />
            </NFormItemGi>
          </template>

          <!-- 类型为2:权限时 需要显示 -->
          <template v-if="showPermission">
            <NFormItemGi span="24 m:12" :label="$t('page.manage.menu.permission')" path="permission">
              <NInput v-model:value="model.permission" :placeholder="$t('page.manage.menu.form.permission')" />
            </NFormItemGi>
          </template>
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
