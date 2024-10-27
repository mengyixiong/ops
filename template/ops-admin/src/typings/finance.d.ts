/**
 * Namespace Api
 *
 * All setting api type
 */
declare namespace Finance {
  namespace FinanceCurrency {
    type Currency = Common.CommonRecord<{
      code: string;
      cn_name: string;
      en_name: string;
      symbol: string;
      is_enable: strin;
    }>;

    /** 提交的数据 */
    type Form = Partial<Currency>;

    /**
     * 列表数据
     */
    type List = Api.Common.PaginatingQueryRecord<Currency>;

    /** 查询参数 */
    type SearchParams = { keyword: string } & Common.CommonSearchParams;
  }
}
