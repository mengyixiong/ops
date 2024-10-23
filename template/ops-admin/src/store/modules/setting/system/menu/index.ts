import {defineStore} from 'pinia';
import {ref} from "vue";
import {useTool} from "@/hooks/common/tool";


export const useMenuStore = defineStore(SetupStoreId.Auth, () => {
  const { extractIdsFromTree } = useTool();
  const expandedIds = ref<number[]>();



  return {
    extractIdsFromTree,
    expandedIds
  };
});
