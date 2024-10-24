<script setup lang="ts">
import { computed } from 'vue';
import type { VNode } from 'vue';
import { useAuthStore } from '@/store/modules/auth';
import { useRouterPush } from '@/hooks/common/router';
import { useSvgIcon } from '@/hooks/common/icon';
import { $t } from '@/locales';
import { fetchChangCompany, fetchLogout } from '@/service/api/auth';
import { useRouteStore } from '@/store/modules/route';

const { toHome } = useRouterPush();

defineOptions({
  name: 'UserAvatar'
});
const routeStore = useRouteStore();
const authStore = useAuthStore();
const { routerPushByKey, toLogin } = useRouterPush();
const { SvgIconVNode } = useSvgIcon();

function loginOrRegister() {
  toLogin();
}

type DropdownKey = 'logout';

type DropdownOption =
  | {
      key: DropdownKey;
      label: string;
      icon?: () => VNode;
    }
  | {
      type: 'divider';
      key: string;
    };

// 用户的主体
const companies = authStore.userInfo?.companies?.map(item => ({
  label: item.name,
  key: `com_${item.id}`
}));

const options = computed(() => {
  const opts: DropdownOption[] = [
    {
      label: $t('common.changeCompany'),
      key: 'changeCompany',
      icon: SvgIconVNode({ icon: 'uil:exchange-alt', fontSize: 18 }),
      children: companies
    },
    {
      label: $t('common.logout'),
      key: 'logout',
      icon: SvgIconVNode({ icon: 'ph:sign-out', fontSize: 18 })
    }
  ];

  return opts;
});

function logout() {
  window.$dialog?.info({
    title: $t('common.tip'),
    content: $t('common.logoutConfirm'),
    positiveText: $t('common.confirm'),
    negativeText: $t('common.cancel'),
    onPositiveClick: async () => {
      const { error } = await fetchLogout();
      if (!error) {
        await authStore.resetStore();
      }
    }
  });
}

function changeCompany(com_id: string) {
  const name = companies?.find(item => item.key === `com_${com_id}`)?.label;

  window.$dialog?.info({
    title: $t('common.tip'),
    content: $t('common.changeCompanyConfirm', { name }),
    positiveText: $t('common.confirm'),
    negativeText: $t('common.cancel'),
    onPositiveClick: async () => {
      const { error } = await fetchChangCompany(com_id);
      if (!error) {
        await window.$message?.success($t('common.changeSuccess'));
        await routeStore.initAuthRoute();
        await authStore.initUserInfo();
        await toHome();
      }
    }
  });
}

function handleDropdown(key: DropdownKey) {
  if (key.includes('com_')) {
    const com_id = key.replace('com_', '');
    changeCompany(com_id);
  } else if (key === 'logout') {
    logout();
  } else {
    routerPushByKey(key);
  }
}
</script>

<template>
  <NButton v-if="!authStore.isLogin" quaternary @click="loginOrRegister">
    {{ $t('page.login.common.loginOrRegister') }}
  </NButton>
  <NDropdown v-else placement="bottom" trigger="click" :options="options" @select="handleDropdown">
    <div>
      <ButtonIcon>
        <SvgIcon icon="ph:user-circle" class="text-icon-large" />
        <span class="text-16px font-medium">{{ authStore.userInfo.nickname }}</span>
      </ButtonIcon>
    </div>
  </NDropdown>
</template>

<style scoped></style>
