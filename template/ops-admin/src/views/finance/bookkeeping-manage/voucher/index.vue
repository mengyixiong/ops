<script setup lang="tsx">
import { NButton, NPopconfirm } from 'naive-ui';
import { $t } from '@/locales';
import { useAppStore } from '@/store/modules/app';
import { useTable, useTableOperate } from '@/hooks/common/table';
import { fetchDel, fetchGetList } from '@/service/api/finance/voucher';
import { yesOrNoRecord } from '@/constants/common';
import OperateDrawer from './modules/operate-drawer.vue';
import SearchForm from './modules/search-form.vue';

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
      key: 'com_id',
      title: $t('page.finance.Voucher.com_id'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'voucher_num',
      title: $t('page.finance.Voucher.voucher_num'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'billing_date',
      title: $t('page.finance.Voucher.billing_date'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'bookkeeper',
      title: $t('page.finance.Voucher.bookkeeper'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'auditor',
      title: $t('page.finance.Voucher.auditor'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'audit_at',
      title: $t('page.finance.Voucher.audit_at'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'cashier',
      title: $t('page.finance.Voucher.cashier'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'make_people',
      title: $t('page.finance.Voucher.make_people'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'make_at',
      title: $t('page.finance.Voucher.make_at'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'dn_total',
      title: $t('page.finance.Voucher.dn_total'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'cn_total',
      title: $t('page.finance.Voucher.cn_total'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
    },
    {
      key: 'is_effective',
      title: $t('page.finance.Voucher.is_effective'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.is_effective;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;

      }
    },
    {
      key: 'is_audit',
      title: $t('page.finance.Voucher.is_audit'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.is_audit;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;

      }
    },
    {
      key: 'is_foreign',
      title: $t('page.finance.Voucher.is_foreign'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.is_foreign;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;

      }
    },
    {
      key: 'is_recorded',
      title: $t('page.finance.Voucher.is_recorded'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.is_recorded;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;

      }
    },
    {
      key: 'type',
      title: $t('page.finance.Voucher.type'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.type;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;

      }
    },
    {
      key: 'remarks',
      title: $t('page.finance.Voucher.remarks'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
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
} = useTableOperate(data, getData);

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
</script>

<template>
  <div class="min-h-500px flex-col-stretch gap-16px overflow-hidden lt-sm:overflow-auto">
    <SearchForm v-model:model="searchParams" @reset="resetSearchParams" @search="getDataByPage" />
    <NCard
      :title="$t('page.finance.Voucher.page.title')"
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
