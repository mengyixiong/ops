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
      is_enable: string;
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


  namespace CostItem {
    type Item = Common.CommonRecord<{
	  name: string;
	  en_name: string;
	  code: string;
	  is_enable: string;
	  remark: string;
    }>;

    /** 提交的数据 */
    type Form = Partial<{Item}>;

    /**
     * 列表数据
     */
    type List = Api.Common.PaginatingQueryRecord<{Item}>;

    /** 查询参数 */
    type SearchParams = { keyword: string } & Common.CommonSearchParams;
  }



  namespace AccountSubject {
    type Item = Common.CommonRecord<{
	  pid: string;
	  level: string;
	  code: string;
	  abb: string;
	  cn_name: string;
	  en_name: string;
	  type: string;
	  format: string;
	  currency: string;
	  com_id: string;
	  is_foreign: string;
	  is_dn: string;
	  is_frozen: string;
	  is_last: string;
	  is_cash: string;
	  balance: string;
	  foreign_balance: string;
	  opening_balance: string;
	  opening_foreign_balance: string;
	  year_opening_balance: string;
	  year_opening_foreign_balance: string;
	  vendor_required: string;
	  clerk_required: string;
	  team_required: string;
	  branch_required: string;
    }>;

    /** 提交的数据 */
    type Form = Partial<{Item}>;

    /**
     * 列表数据
     */
    type List = Api.Common.PaginatingQueryRecord<{Item}>;

    /** 查询参数 */
    type SearchParams = { keyword: string } & Common.CommonSearchParams;
  }

}