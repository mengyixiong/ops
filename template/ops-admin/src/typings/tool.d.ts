/**
 * Namespace Api
 *
 * All Tool api type
 */
declare namespace Tool {
  namespace GenerateRecord {
    type Item = Common.CommonRecord<{
      table_name: string;
      controller: string;
      logic: string;
      add_request: string;
      update_request: string;
      index_vue: string;
      api_type: string;
      search_form: string;
      operate_drawer: string;
      lang_zh: string;
      service_api: string;
    }>;

    /** 提交的数据 */
    type Form = {
      module: string;
      path: string;
      front_path: string;
      table_name: string;
      prefix: string;
      is_test?: boolean;
    };

    /** 列表数据 */
    type List = Api.Common.PaginatingQueryRecord<Item>;

    /** 查询参数 */
    type SearchParams = { keyword: string } & Common.CommonSearchParams;
  }
}
