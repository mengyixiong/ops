/**
 * Namespace Api
 *
 * All setting api type
 */
declare namespace Setting {
  namespace SystemAdmin{
    type Admin = Common.CommonRecord<{
      username: string;
      is_enable: string;
      is_super_admin: string;
      current_com_name: string;
      avatar: string;
      email: string;
      phone: string;
      last_login_at: string;
      last_login_ip: string;
      deleted_at: string;
    }>;

    /** 提交的主体数据 */
    type Form = Partial<Admin> & { roles: string[] };
  }
  namespace SystemRole {
    type Role = Api.Common.CommonRecord<{
      name: string;
      code: string;
      description: string;
    }>;

    type AllRole = Pick<Role, 'id' | 'name' | 'code'>;

    /** 提交的主体数据 */
    type Form = Partial<Role>;

    /** user search params */
    type SearchParams = Partial<Pick<Role, 'name' | 'code'> & Api.Common.CommonSearchParams>;
  }

  /** 系统管理的主体 api type */
  namespace SystemCompany {
    type Company = Api.Common.CommonRecord<{
      name: string;
      is_default: string;
      abb: string;
    }>;

    /** 提交的主体数据 */
    type Form = Partial<SystemCompany>;

    /** 主体列表 */
    type List = Api.Common.PaginatingQueryRecord<Company>;

    /** user search params */
    type SearchParams = Partial<Pick<Company, 'name' | 'is_default'> & Api.Common.CommonSearchParams>;
  }
}
