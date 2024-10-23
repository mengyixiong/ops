<script setup lang="ts">
import { computed, reactive, ref, watch } from 'vue';
import { NButton } from 'naive-ui';
import { useFormRules, useNaiveForm } from '@/hooks/common/form';
import { fetchAdd, fetchEdit, fetchGetAllRoles } from '@/service/api/system/admin';
import { $t } from '@/locales';
import { enableStatusOptions } from '@/constants/business';
import { yesOrNoOptions } from '@/constants/common';
import { baseUrl } from '@/service/request';

defineOptions({
  name: 'UserOperateDrawer'
});

interface Props {
  /** the type of operation */
  operateType: NaiveUI.TableOperateType;
  /** the edit row data */
  rowData?: Api.SystemManage.User | null;
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

// 标题
const title = computed(() => {
  const titles: Record<NaiveUI.TableOperateType, string> = {
    add: $t('page.manage.user.add'),
    edit: $t('page.manage.user.edit')
  };
  return titles[props.operateType];
});

// 表单数据
type Model = Setting.SystemAdmin.Form;
const model: Model = reactive(createDefaultModel());

function createDefaultModel(): Model {
  return {
    avatar: '',
    username: '',
    is_enable: 'N',
    is_super_admin: 'N',
    avatar: '',
    email: '',
    phone: '',
    roles: []
  };
}

// 表单规则
const { defaultRequiredRule } = useFormRules();
type RuleKey = Extract<keyof Model, 'userName' | 'status'>;
const rules: Record<RuleKey, App.Global.FormRule> = {
  username: defaultRequiredRule,
  email: defaultRequiredRule,
  roles: defaultRequiredRule
};

/** 获取所有角色 */
const roleOptions = ref<CommonType.Option<string>[]>([]);

async function getRoleOptions() {
  const { error, data } = await fetchGetAllRoles();

  if (!error) {
    roleOptions.value = data.map(item => ({
      label: item.name,
      value: item.id
    }));
  }
}

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

watch(visible, () => {
  if (visible.value) {
    handleInitModel();
    restoreValidation();
    getRoleOptions();
  }
});

const handleFinish = ({ file, event }: { file: UploadFileInfo; event?: ProgressEvent }) => {
  if ((event?.target as XMLHttpRequest).response) {
    const resp = JSON.parse(event.target.response);
    if (resp.code === 200) {
      model.avatar = resp.data.url;
      console.log(model)
      return file;
    }
  }
  window.$message?.error($t('common.uploadFailed'));
};
</script>

<template>
  <NDrawer v-model:show="visible" display-directive="show" :width="360">
    <NDrawerContent :title="title" :native-scrollbar="false" closable>
      <NForm ref="formRef" :model="model" :rules="rules">
        <NFormItem :label="$t('page.manage.user.username')" path="username">
          <NInput v-model:value="model.username" :placeholder="$t('page.manage.user.form.username')" />
        </NFormItem>
        <NFormItem :label="$t('page.manage.user.avatar')" path="avatar">
          <NUpload
            show-remove-button
            :show-file-list="false"
            :trigger-style="{ borderRadius: '50%' }"
            :action="baseUrl + '/upload/upload_avatar'"
            @finish="handleFinish"
          >
            <template #default>
              <NAvatar
                round
                :size="100"
                :src="model.avatar"
                fallback-src="https://07akioni.oss-cn-beijing.aliyuncs.com/07akioni.jpeg"
              />
            </template>
          </NUpload>
        </NFormItem>
        <NFormItem :label="$t('page.manage.user.password')" path="password">
          <NInput v-model:value="model.password" :placeholder="$t('page.manage.user.form.password')" />
        </NFormItem>
        <NFormItem :label="$t('page.manage.user.email')" path="email">
          <NInput v-model:value="model.email" :placeholder="$t('page.manage.user.form.email')" />
        </NFormItem>
        <NFormItem :label="$t('page.manage.user.phone')" path="phone">
          <NInput v-model:value="model.phone" :placeholder="$t('page.manage.user.form.phone')" />
        </NFormItem>
        <NFormItem :label="$t('page.manage.user.is_enable')" path="is_enable">
          <NRadioGroup v-model:value="model.is_enable">
            <NRadio v-for="item in enableStatusOptions" :key="item.value" :value="item.value" :label="$t(item.label)" />
          </NRadioGroup>
        </NFormItem>
        <NFormItem :label="$t('page.manage.user.is_super_admin')" path="is_super_admin">
          <NRadioGroup v-model:value="model.is_super_admin">
            <NRadio v-for="item in yesOrNoOptions" :key="item.value" :value="item.value" :label="$t(item.label)" />
          </NRadioGroup>
        </NFormItem>
        <NFormItem :label="$t('page.manage.user.roles')" path="roles">
          <NSelect
            v-model:value="model.roles"
            clearable
            filterable
            multiple
            :options="roleOptions"
            :placeholder="$t('page.manage.user.form.roles')"
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
