<script setup lang="tsx">
import type { Ref } from 'vue';
import { ref } from 'vue';
import { NButton, NPopconfirm, NTag } from 'naive-ui';
import { useBoolean } from '@sa/hooks';
import { fetchGetList } from '@/service/api/system/menu';
import { useAppStore } from '@/store/modules/app';
import { useTable, useTableOperate } from '@/hooks/common/table';
import { $t } from '@/locales';
import { yesOrNoRecord } from '@/constants/common';
import { menuTypeRecord } from '@/constants/business';
import SvgIcon from '@/components/custom/svg-icon.vue';
import MenuOperateModal, { type OperateType } from './modules/menu-operate-modal.vue';

const appStore = useAppStore();
const { bool: visible, setTrue: openModal } = useBoolean();
const wrapperRef = ref<HTMLElement | null>(null);
const operateType = ref<OperateType>('add');
const { columns, columnChecks, data, loading, pagination, getData, getDataByPage } = useTable({
  apiFn: fetchGetList,
  columns: () => [
    {
      type: 'selection',
      align: 'center',
      width: 48
    },
    {
      key: 'id',
      title: $t('page.manage.menu.id'),
      align: 'center'
    },
    {
      key: 'title',
      title: $t('page.manage.menu.title'),
      align: 'center'
    },
    {
      key: 'type',
      title: $t('page.manage.menu.type'),
      align: 'center',
      width: 80,
      render: row => {
        const tagMap: Record<Setting.SystemMenu.MenuType, NaiveUI.ThemeColor> = {
          1: 'default',
          2: 'primary'
        };

        const label = $t(menuTypeRecord[row.type]);

        return <NTag type={tagMap[row.type]}>{label}</NTag>;
      }
    },
    {
      key: 'name',
      title: $t('page.manage.menu.name'),
      align: 'center',
      minWidth: 120,
      render: row => {
        const { i18nKey, name } = row;

        const label = i18nKey ? $t(i18nKey) : name;

        return <span>{label}</span>;
      }
    },
    {
      key: 'icon',
      title: $t('page.manage.menu.icon'),
      align: 'center',
      width: 60,
      render: row => {
        const icon = row.icon;

        const localIcon = undefined;

        return (
          <div class="flex-center">
            <SvgIcon icon={icon} localIcon={localIcon} class="text-icon" />
          </div>
        );
      }
    },
    {
      key: 'path',
      title: $t('page.manage.menu.path'),
      align: 'center',
      minWidth: 120
    },
    {
      key: 'component',
      title: `${$t('page.manage.menu.component')}/${$t('page.manage.menu.permission')}`,
      align: 'center',
      minWidth: 150,
      render: row => {
        const tagMap: Record<Setting.SystemMenu.MenuType, NaiveUI.ThemeColor> = {
          1: 'default',
          2: 'primary'
        };

        const label = row.type === '1' ? row.component : row.permission;

        return <NTag type={tagMap[row.type]}>{label}</NTag>;
      }
    },
    {
      key: 'is_hide_menu',
      title: $t('page.manage.menu.is_hide_menu'),
      align: 'center',
      width: 80,
      render: row => {
        if (row.is_hide_menu === null) {
          return null;
        }

        const hide: CommonType.YesOrNo = row.is_hide_menu;

        const tagMap: Record<CommonType.YesOrNo, NaiveUI.ThemeColor> = {
          Y: 'error',
          N: 'default'
        };

        const label = $t(yesOrNoRecord[hide]);

        return <NTag type={tagMap[hide]}>{label}</NTag>;
      }
    },
    {
      key: 'sort',
      title: $t('page.manage.menu.sort'),
      align: 'center',
      width: 60
    },
    {
      key: 'operate',
      title: $t('common.operate'),
      align: 'center',
      width: 230,
      render: row => (
        <div class="flex-center justify-end gap-8px">
          {row.type === '1' && (
            <NButton type="primary" ghost size="small" onClick={() => handleAddChildMenu(row)}>
              {$t('page.manage.menu.addChildMenu')}
            </NButton>
          )}
          <NButton type="primary" ghost size="small" onClick={() => handleEdit(row)}>
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
const { checkedRowKeys, onBatchDeleted, onDeleted } = useTableOperate(data, getData);
const expands = ref<number[]>([]); // 展开的菜单
const editingData: Ref<Setting.SystemMenu.Menu | null> = ref(null); // 编辑的数据

function handleAdd() {
  operateType.value = 'add';
  openModal();
}

async function handleBatchDelete() {
  onBatchDeleted();
}


function handleDelete(id: number) {
  console.log(id)
  onDeleted();
}

function handleEdit(item: Setting.SystemMenu.Menu) {
  operateType.value = 'edit';
  editingData.value = { ...item };
  openModal();
}

function handleAddChildMenu(item: Api.SystemManage.Menu) {
  operateType.value = 'addChild';
  editingData.value = { ...item };
  openModal();
}

</script>

<template>
  <div ref="wrapperRef" class="flex-col-stretch gap-16px overflow-hidden lt-sm:overflow-auto">
    <NCard :title="$t('page.manage.menu.title')" :bordered="false" size="small" class="sm:flex-1-hidden card-wrapper">
      <template #header-extra>
        <TableHeaderOperation
          v-model:columns="columnChecks"
          :disabled-delete="checkedRowKeys.length === 0"
          :loading="loading"
          @add="handleAdd"
          @delete="handleBatchDelete"
          @refresh="getData"
        >

        </TableHeaderOperation>
      </template>
      <NDataTable
        v-model:checked-row-keys="checkedRowKeys"
        :row-key="row => row.id"
        :columns="columns"
        :data="data"
        size="small"
        :flex-height="!appStore.isMobile"
        :scroll-x="1088"
        :loading="loading"
        remote
        :pagination="pagination"
        class="sm:h-full"
      />
      <MenuOperateModal
        v-model:visible="visible"
        :operate-type="operateType"
        :row-data="editingData"
        :all-pages="[]"
        @submitted="getDataByPage"
      />
    </NCard>
  </div>
</template>

<style scoped></style>
