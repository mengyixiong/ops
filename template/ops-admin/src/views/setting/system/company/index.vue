<script setup lang="tsx">
import { NButton, NPopconfirm, NTag } from 'naive-ui';
import { $t } from '@/locales';
import { useAppStore } from '@/store/modules/app';
import { YesOrNoRecord } from '@/constants/business';
import { useTable, useTableOperate } from '@/hooks/common/table';
import { fetchDel, fetchGetCompanyList } from '@/service/api/system/company';
import OperateDrawer from './modules/operate-drawer.vue';
import CompanySearch from './modules/company-search.vue';

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
  apiFn: fetchGetCompanyList,
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
      title: $t('page.manage.company.name'),
      align: 'center',
      minWidth: 100
    },
    {
      key: 'is_default',
      title: $t('page.manage.company.is_default'),
      align: 'center',
      width: 100,
      render: row => {
        if (row.is_default === null) {
          return null;
        }

        const tagMap: Record<Api.Common.EnableStatus, NaiveUI.ThemeColor> = {
          Y: 'primary',
          N: 'error'
        };

        const label = $t(YesOrNoRecord[row.is_default]);

        return <NTag type={tagMap[row.is_default]}>{label}</NTag>;
      }
    },
    {
      key: 'abb',
      title: $t('page.manage.company.abb'),
      align: 'center',
      minWidth: 100
    },
    {
      key: 'created_at',
      title: $t('common.created_at'),
      align: 'center',
      minWidth: 100
    },
    {
      key: 'updated_at',
      title: $t('common.updated_at'),
      align: 'center',
      minWidth: 100
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

/**
 * 批量删除
 */
async function handleBatchDelete() {
  // request

  await onBatchDeleted();
}

async function handleDelete(id: number) {
  // request
  await fetchDel(id);
  await onDeleted();
}

function edit(id: number) {
  handleEdit(id);
}
</script>

<template>
  <div class="min-h-500px flex-col-stretch gap-16px overflow-hidden lt-sm:overflow-auto">
    <CompanySearch v-model:model="searchParams" @reset="resetSearchParams" @search="getDataByPage" />
    <NCard
      :title="$t('page.manage.company.title')"
      :bordered="false"
      size="small"
      class="sm:flex-1-hidden card-wrapper"
    >
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
    </NCard>
  </div>
</template>

<style scoped></style>
