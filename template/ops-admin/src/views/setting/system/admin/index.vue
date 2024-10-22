<script setup lang="tsx">
import { NButton, NPopconfirm, NTag } from 'naive-ui';
import { fetchDel, fetchGetUserList } from '@/service/api/system/admin';
import { $t } from '@/locales';
import { useAppStore } from '@/store/modules/app';
import { YesOrNoRecord } from '@/constants/business';
import { useTable, useTableOperate } from '@/hooks/common/table';
import UserOperateDrawer from './modules/user-operate-drawer.vue';
import UserSearch from './modules/user-search.vue';

const appStore = useAppStore();

const {
  columns,
  columnChecks,
  data,
  getData,
  getDataByPage,
  loading,
  mobilePagination,
  searchParams,
  resetSearchParams
} = useTable({
  apiFn: fetchGetUserList,
  showTotal: true,
  apiParams: {
    page: 1,
    limit: 10,
    // if you want to use the searchParams in Form, you need to define the following properties, and the value is null
    // the value can not be undefined, otherwise the property in Form will not be reactive
    status: null,
    userName: null,
    userGender: null,
    nickName: null,
    userPhone: null,
    userEmail: null
  },
  columns: () => [
    {
      type: 'selection',
      fixed: 'left',
      align: 'center',
      width: 48
    },
    {
      key: 'operate',
      title: $t('common.operate'),
      align: 'center',
      width: 130,
      render: row => (
        <div class="flex-center gap-8px">
          <NButton type="primary" ghost size="small" onClick={() => edit(row.id)}>
            {$t('common.edit')}
          </NButton>
          <NPopconfirm onPositiveClick={() => handleDelete(row.id)}>
            {{
              default: () => $t('common.confirmDelete'),
              trigger: () => (
                <NButton type="error" ghost size="small">
                  {$t('common.delete')}
                </NButton>
              )
            }}
          </NPopconfirm>
        </div>
      )
    },
    {
      key: 'index',
      title: $t('common.index'),
      align: 'center',
      width: 64
    },
    {
      key: 'username',
      title: $t('page.manage.user.username'),
      align: 'center',
      minWidth: 100
    },
    {
      key: 'is_enable',
      title: $t('page.manage.user.is_enable'),
      align: 'center',
      width: 100,
      render: row => {
        if (row.is_enable === null) {
          return null;
        }

        const tagMap: Record<Api.Common.EnableStatus, NaiveUI.ThemeColor> = {
          Y: 'primary',
          N: 'error'
        };

        const label = $t(YesOrNoRecord[row.is_enable]);

        return <NTag type={tagMap[row.is_enable]}>{label}</NTag>;
      }
    },
    {
      key: 'is_super_admin',
      title: $t('page.manage.user.is_super_admin'),
      align: 'center',
      width: 100,
      render: row => {
        if (row.is_super_admin === null) {
          return null;
        }

        const tagMap: Record<Api.Common.EnableStatus, NaiveUI.ThemeColor> = {
          Y: 'primary',
          N: 'error'
        };

        const label = $t(YesOrNoRecord[row.is_super_admin]);

        return <NTag type={tagMap[row.is_super_admin]}>{label}</NTag>;
      }
    },
    {
      key: 'current_com_name',
      title: $t('page.manage.user.current_com_name'),
      align: 'center',
      minWidth: 100
    },
    {
      key: 'avatar',
      title: $t('page.manage.user.avatar'),
      align: 'center',
      width: 120
    },
    {
      key: 'email',
      title: $t('page.manage.user.email'),
      align: 'center',
      minWidth: 200
    },
    {
      key: 'phone',
      title: $t('page.manage.user.phone'),
      align: 'center',
      minWidth: 200
    },
    {
      key: 'last_login_at',
      title: $t('page.manage.user.last_login_at'),
      align: 'center',
      minWidth: 200
    },
    {
      key: 'last_login_ip',
      title: $t('page.manage.user.last_login_ip'),
      align: 'center',
      minWidth: 200
    },
    {
      key: 'created_at',
      title: $t('common.created_at'),
      align: 'center',
      minWidth: 200
    },
    {
      key: 'updated_at',
      title: $t('common.updated_at'),
      align: 'center',
      minWidth: 200
    }
  ]
});
const {
  drawerVisible,
  operateType,
  editingData,
  handleAdd,
  handleEdit,
  checkedRowKeys,
  onBatchDeleted,
  onDeleted
  // closeDrawer
} = useTableOperate(data, getData);

async function handleBatchDelete() {
  // request
  console.log(checkedRowKeys.value);

  onBatchDeleted();
}

async function handleDelete(id: number) {
  // request
  const { error } = await fetchDel(id);
  if (!error) {
    await onDeleted();
  }
}

function edit(id: number) {
  handleEdit(id);
}
</script>

<template>
  <div class="min-h-500px flex-col-stretch gap-16px overflow-hidden lt-sm:overflow-auto">
    <UserSearch v-model:model="searchParams" @reset="resetSearchParams" @search="getDataByPage" />
    <NCard :title="$t('page.manage.user.title')" :bordered="false" size="small" class="sm:flex-1-hidden card-wrapper">
      <template #header-extra>
        <TableHeaderOperation
          v-model:columns="columnChecks"
          :disabled-delete="checkedRowKeys.length === 0"
          :loading="loading"
          @add="handleAdd"
          @delete="handleBatchDelete"
          @refresh="getData"
        />
      </template>
      <NDataTable
        v-model:checked-row-keys="checkedRowKeys"
        :columns="columns"
        :data="data"
        size="small"
        :flex-height="!appStore.isMobile"
        :scroll-x="2000"
        :loading="loading"
        remote
        :row-key="row => row.id"
        :pagination="mobilePagination"
        class="sm:h-full"
      />
      <UserOperateDrawer
        v-model:visible="drawerVisible"
        :operate-type="operateType"
        :row-data="editingData"
        @submitted="getDataByPage"
      />
    </NCard>
  </div>
</template>

<style scoped></style>
