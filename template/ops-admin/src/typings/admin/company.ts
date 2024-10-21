/**
 * Namespace AdminCompany
 * 主体的所有api.type
 */
// eslint-disable-next-line @typescript-eslint/no-unused-vars,@typescript-eslint/no-namespace
declare namespace AdminCompany {
  type Company = Api.Common.CommonRecord<{
    name: string;
    is_default: string;
    abb: string;
  }>;

  type List = Api.Common.PaginatingQueryRecord<Company>;

  /** user search params */
  type SearchParams = Partial<Pick<AdminCompany.Company, 'name' | 'abb'> & Api.Common.CommonSearchParams>;
}
