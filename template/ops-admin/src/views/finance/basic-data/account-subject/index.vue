<script setup lang="tsx">
import { NButton, NPopconfirm } from 'naive-ui';
import { $t } from '@/locales';
import { useAppStore } from '@/store/modules/app';
import { useTable, useTableOperate } from '@/hooks/common/table';
import { fetchDel, fetchGetList } from '@/service/api/finance/account_subject';
import { yesOrNoRecord } from '@/constants/common';
import SvgIcon from '@/components/custom/svg-icon.vue';
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
          <NButton type="primary" ghost size="small" onClick={() => add(row)}>
            <SvgIcon icon="ep:plus"></SvgIcon>
            {$t('page.finance.AccountSubject.addChild')}
          </NButton>
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
      key: 'pid',
      title: $t('page.finance.AccountSubject.pid'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'level',
      title: $t('page.finance.AccountSubject.level'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'code',
      title: $t('page.finance.AccountSubject.code'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'abb',
      title: $t('page.finance.AccountSubject.abb'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'cn_name',
      title: $t('page.finance.AccountSubject.cn_name'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'en_name',
      title: $t('page.finance.AccountSubject.en_name'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'type',
      title: $t('page.finance.AccountSubject.type'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'format',
      title: $t('page.finance.AccountSubject.format'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'currency',
      title: $t('page.finance.AccountSubject.currency'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'com_id',
      title: $t('page.finance.AccountSubject.com_id'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'is_foreign',
      title: $t('page.finance.AccountSubject.is_foreign'),
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
      key: 'is_dn',
      title: $t('page.finance.AccountSubject.is_dn'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.is_dn;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
      }
    },
    {
      key: 'is_frozen',
      title: $t('page.finance.AccountSubject.is_frozen'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.is_frozen;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
      }
    },
    {
      key: 'is_last',
      title: $t('page.finance.AccountSubject.is_last'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.is_last;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
      }
    },
    {
      key: 'is_cash',
      title: $t('page.finance.AccountSubject.is_cash'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.is_cash;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
      }
    },
    {
      key: 'balance',
      title: $t('page.finance.AccountSubject.balance'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'foreign_balance',
      title: $t('page.finance.AccountSubject.foreign_balance'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'opening_balance',
      title: $t('page.finance.AccountSubject.opening_balance'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'opening_foreign_balance',
      title: $t('page.finance.AccountSubject.opening_foreign_balance'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'year_opening_balance',
      title: $t('page.finance.AccountSubject.year_opening_balance'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'year_opening_foreign_balance',
      title: $t('page.finance.AccountSubject.year_opening_foreign_balance'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      }
    },
    {
      key: 'vendor_required',
      title: $t('page.finance.AccountSubject.vendor_required'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.vendor_required;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
      }
    },
    {
      key: 'clerk_required',
      title: $t('page.finance.AccountSubject.clerk_required'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.clerk_required;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
      }
    },
    {
      key: 'team_required',
      title: $t('page.finance.AccountSubject.team_required'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.team_required;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
      }
    },
    {
      key: 'branch_required',
      title: $t('page.finance.AccountSubject.branch_required'),
      align: 'center',
      minWidth: 100,
      ellipsis: {
        tooltip: true
      },
      render: row => {
        const hide: CommonType.YesOrNo = row.branch_required;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'success',
          N: 'error'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
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

function add(row) {
  editingData.value = {
    pid: row.id,
    level: Number.parseInt(row.level, 10) + 1,
    code: '1001',
    abb: '',
    cn_name: '',
    en_name: '',
    type: 'asset',
    format: 'amount',
    currency: 'CNY',
    com_id: 1,
    is_foreign: 'N',
    is_dn: 'Y',
    is_frozen: 'N',
    is_last: 'N',
    is_cash: 'Y',
    vendor_required: 'Y',
    clerk_required: 'N',
    team_required: 'N',
    branch_required: 'Y'
  };
  console.log(editingData);
  handleAdd();
}
</script>

<template>
  <div class="min-h-500px flex-col-stretch gap-16px overflow-hidden lt-sm:overflow-auto">
    <SearchForm v-model:model="searchParams" @reset="resetSearchParams" @search="getDataByPage" />
    <NCard
      :title="$t('page.finance.AccountSubject.page.title')"
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
