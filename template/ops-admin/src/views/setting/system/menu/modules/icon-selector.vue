<script setup lang="tsx">
import { computed, ref, watch } from 'vue';
import { $t } from '@/locales';
import { fetchGetAllCompanies } from '@/service/api/system/company';
import { jsonClone } from '@sa/utils';
import antDesign from '@/assets/iconify/ant-design.json';
import box from '@/assets/iconify/box.json';
import elementPlus from '@/assets/iconify/element-plus.json';
import flagPack from '@/assets/iconify/flagpack.json';
import heroIcon from '@/assets/iconify/heroicons.json';
import logos from '@/assets/iconify/logos.json';
import materialDesign from '@/assets/iconify/mdi.json';
import remix from '@/assets/iconify/ri.json';
import twitterEmoji from '@/assets/iconify/twemoji.json';
import weUI from '@/assets/iconify/weui.json';

const iconList = { antDesign, box, elementPlus, flagPack, heroIcon, logos, materialDesign, remix, twitterEmoji, weUI };

defineOptions({
  name: 'MenuOperateModal'
});

export type OperateType = NaiveUI.TableOperateType | 'addChild';

interface Props {
  /** the type of operation */
  icon?: OperateType;
  /** the edit menu data or the parent menu data when adding a child menu */
  rowData?: Setting.SystemMenu.Menu | null;
}

const props = defineProps<Props>();

interface Emits {
  (e: 'submitted'): void;
}

const emit = defineEmits<Emits>();

const visible = defineModel<boolean>('visible', {
  visible: false
});

const icon = defineModel<string>('icon', {
  icon: ''
});


function closeDrawer() {
  visible.value = false;
}

function selectIcon(selectedIcon) {
  icon.value = selectedIcon;
  closeDrawer();
}

const active = ref('antDesign');
const icons = ref<string[]>([]);
const showIcons = ref<string[]>([]);
const originIcons = ref<string[]>([]);
const page = ref(1);
const limit = ref(60);

function changeGroup(index) {
  icons.value = [];
  icons.value = iconList[index];
  page.value = 1;
  active.value = index;
  showIcons.value = getPaginatedData(icons.value, 1, limit.value);
  originIcons.value = jsonClone(icons.value);
}

function getPaginatedData(data, currentPage, pageSize) {
  // 计算开始和结束索引
  const startIndex = (currentPage - 1) * pageSize;
  const endIndex = startIndex + pageSize;

  // 返回该页的数据
  return data.slice(startIndex, endIndex);
}

function changePage(currentPage) {
  page.value = currentPage;
}

watch(page, () => {
  showIcons.value = getPaginatedData(icons.value, page.value, limit.value);
});
// 计算总页数
const allPage = computed(() => {
  return Math.ceil(icons.value.length / limit.value);
});

// 搜索图标
function searchIcons(keyword) {
  if (keyword) {
    icons.value = originIcons.value.filter(icon => icon.includes(keyword));
  } else {
    // 如果关键字为空，还原显示的图标为原始图标
    icons.value = jsonClone(originIcons.value);
  }
  showIcons.value = getPaginatedData(icons.value, 1, limit.value);
}

watch(visible, () => {
  if (visible.value) {
    changeGroup('antDesign');
  }
});
</script>

<template>
  <NModal v-model:show="visible" title="选择图标" preset="card" class="w-800px">
    <NScrollbar class="h-480px pr-20px">
      <NGrid x-gap="12" y-gap="12" :cols="4">
        <NGi :span="1" class="left">
          <NList>
            <NListItem
              v-for="(item, index) in iconList"
              :key="index"
              class="item"
              :class="[active === index ? 'active' : '']"
              @click="changeGroup(index)"
            >
              {{ index }}
            </NListItem>
          </NList>
        </NGi>
        <NGi :span="3">
          <div>
            <NInput placeholder="搜索此分类下的图标" @input="searchIcons"/>
          </div>
          <NGrid x-gap="12" y-gap="20" :cols="10">
            <NGi v-for="(item, index) in showIcons" :key="index" :span="1">
              <div class="icon-item" @click="selectIcon(item)">
                <SvgIcon :icon="item" class="h-25px w-25px"></SvgIcon>
              </div>
            </NGi>
          </NGrid>
          <div class="float-right" style="margin-top: 20px">
            <NPagination v-model:page="page" :page-count="allPage" @update:page="changePage" />
          </div>
        </NGi>
      </NGrid>
    </NScrollbar>
  </NModal>
</template>

<style scoped>
.left {
  border-right: 2px solid #e4e7ed;
}

.item {
  cursor: pointer;
}

.item:hover {
  color: #2563eb;
}

.active {
  color: #2563eb;
}

.icon-item {
  border: 1px solid #fff;
  padding: 10px;
}

.icon-item:hover {
  background: #f5f5f5;
  border-radius: 10px;
  border: 1px solid #2563eb;
}
</style>
