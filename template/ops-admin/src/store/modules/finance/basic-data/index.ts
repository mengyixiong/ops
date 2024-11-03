import { defineStore }             from 'pinia';
import { effectScope, ref }        from 'vue';
import { fetchGetInitData }        from '@/service/api/finance/public';
import { transformRecordToOption } from '@/utils/common';
import { SetupStoreId }            from '@/enum';
import { useBoolean }              from '~/packages/hooks';

export const useFinanceBasicDataStore = defineStore(SetupStoreId.FinanceBasicData, () => {
  const scope = effectScope();
  const currencyMap = ref({});
  const currencyOptions = ref([]);
  const levelMap = ref({});
  const typeMap = ref({});
  const formatMap = ref({});
  const rateTypeMap = ref({});
  const levelOptions = ref([]);
  const typeOptions = ref([]);
  const formatOptions = ref([]);
  const rateTypeOptions = ref([]);

  const { bool: isCurrencyLoaded, setBool: setCurrencyLoaded } = useBoolean();

  async function getInitData() {
    if (isCurrencyLoaded.value) return;

    const { data, error } = await fetchGetInitData();
    if (!error) {
      currencyMap.value = data.currencyMap;
      levelMap.value = data.levelMap;
      typeMap.value = data.typeMap;
      formatMap.value = data.formatMap;
      rateTypeMap.value = data.rateTypeMap;
      currencyOptions.value = transformRecordToOption(currencyMap.value);
      levelOptions.value = transformRecordToOption(levelMap.value);
      typeOptions.value = transformRecordToOption(typeMap.value);
      formatOptions.value = transformRecordToOption(formatMap.value);
      rateTypeOptions.value = transformRecordToOption(rateTypeMap.value);
      setCurrencyLoaded();
    }
  }

  scope.run(() => {
    getInitData();
  });

  return {
    currencyMap,
    currencyOptions,
    levelMap,
    typeMap,
    formatMap,
    rateTypeMap,
    levelOptions,
    typeOptions,
    formatOptions,
    rateTypeOptions
  };
});
