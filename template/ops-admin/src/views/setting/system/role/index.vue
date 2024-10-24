<script setup lang="tsx">
import {NButton, NPopconfirm} from 'naive-ui';
import {ref} from 'vue'
import {$t} from '@/locales';
import {useAppStore} from '@/store/modules/app';
import {useTable, useTableOperate} from '@/hooks/common/table';
import {fetchDel, fetchGetList} from '@/service/api/system/role';
import OperateDrawer from './modules/operate-drawer.vue';
import SearchForm from './modules/search-form.vue';
import AssignPermission from './modules/assign-permission.vue'

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
  apiFn: fetchGetList,
  showTotal: true,
  apiParams: {
    page: 1,
    limit: 10
  },
  columns: () => [
    {
      type: 'selection',
      fixed: 'left',
      align: 'center',
      width: 48
    },
    {
      key: 'index',
      title: $t('common.index'),
      align: 'center',
      width: 64
    },
    {
      key: 'name',
      title: $t('page.manage.role.name'),
      align: 'center',
      minWidth: 100
    },
    {
      key: 'code',
      title: $t('page.manage.role.code'),
      align: 'center',
      width: 100
    },
    {
      key: 'description',
      title: $t('page.manage.role.description'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'created_at',
      title: $t('common.created_at'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'updated_at',
      title: $t('common.updated_at'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'operate',
      title: $t('common.operate'),
      align: 'center',
      width: 200,
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
          <NButton type="primary" ghost size="small" onClick={() => assignPermission(row)}>
            {$t('page.manage.role.assignPermissions')}
          </NButton>
        </div>
      )
    }
  ]
});

const { drawerVisible, operateType, editingData, handleAdd, handleEdit, checkedRowKeys, onBatchDeleted, onDeleted } =
  useTableOperate(data, getData);

/** 批量删除 */
async function handleBatchDelete() {
  await onBatchDeleted();
}

async function handleDelete(id: number) {
  const { error } = await fetchDel(id);
  if (!error) {
    await onDeleted();
  }
}

function edit(id: number) {
  handleEdit(id);
}

/**
 * 分配权限
 *
 */
const assignPermissionVisible = ref(false);
function assignPermission(row: Setting.SystemRole.Role) {
  assignPermissionVisible.value = true;
  editingData.value = row;
}
</script>

<template>
  <div class="min-h-500px flex-col-stretch gap-16px overflow-hidden lt-sm:overflow-auto">
    <SearchForm v-model:model="searchParams" @reset="resetSearchParams" @search="getDataByPage"/>
    <NCard :title="$t('page.manage.role.title')" :bordered="false" size="small" class="sm:flex-1-hidden card-wrapper">
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
        :scroll-x="800"
        :loading="loading"
        remote
        :row-key="row => row.id"
        :pagination="mobilePagination"
        class="sm:h-full"
      />
      <OperateDrawer
        v-model:visible="drawerVisible"
        :operate-type="operateType"
        :row-data="editingData"
        @submitted="getDataByPage"
      />

      <AssignPermission
        v-model:visible="assignPermissionVisible"
        :row-data="editingData"
      />
    </NCard>
  </div>
</template>

<style scoped></style>
