/**
 * Namespace Api
 *
 * All {module} api type
 */
declare namespace {module} {
  namespace {featureName} {
    type Item = Common.CommonRecord<{
{apiColumns}
    }>;

    /** 提交的数据 */
    type Form = Partial<Item>;

    /**
     * 列表数据
     */
    type List = Api.Common.PaginatingQueryRecord<Item>;

    /** 查询参数 */
    type SearchParams = { keyword: string } & Common.CommonSearchParams;
  }

