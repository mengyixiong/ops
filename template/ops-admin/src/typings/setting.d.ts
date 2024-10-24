/**
 * Namespace Api
 *
 * All setting api type
 */
declare namespace Setting {
  namespace SystemAdmin {
    type Admin = Common.CommonRecord<{
      nickname: string;
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
    type Form = Partial<Admin> & {
      roles: number[];
      role_names: string[];
      companies: number[];
      company_names: string[];
    };
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
    type Form = Partial<Company>;

    /** 主体列表 */
    type List = Api.Common.PaginatingQueryRecord<Company>;

    /** user search params */
    type SearchParams = Partial<Pick<Company, 'name' | 'is_default'> & Api.Common.CommonSearchParams>;
  }

  namespace SystemMenu {
    /**
     * menu type
     *
     * - "1": menu
     * - "2": permission
     */
    type MenuType = '1' | '2';

    type MenuButton = {
      /**
       * button code
       *
       * it can be used to control the button permission
       */
      code: string;
      /** button description */
      desc: string;
    };

    /**
     * icon type
     *
     * - "1": iconify icon
     * - "2": local icon
     */
    type IconType = '1' | '2';

    type Menu = Common.CommonRecord<{
      /** 主体id集合 */
      com_id: number[];
      /** 是否隐藏菜单 */
      is_hide_menu: boolean;
      /** parent menu id */
      pid: number;
      /** menu type */
      type: MenuType;
      /** menu name */
      title: string;
      /** route name */
      name: string;
      /** route path */
      path: string;
      /** component */
      component?: string;
      /** iconify icon name or local icon name */
      icon: string;
      /** children menu */
      children?: Menu[];

    }>;

    /** menu list */
    type MenuList = Api.Common.CommonRecord

    type MenuTree = {
      id: number;
      title: string;
      pid: number;
      children?: MenuTree[];
    };

    /** 提交的主体数据 */
    type Form = Partial<Menu>;

    /** 主体列表 */
    type List = Api.Common.PaginatingQueryRecord<Menu>;

    /** user search params */
    type SearchParams = Partial<Pick<Menu, 'name'> & Api.Common.CommonSearchParams>;

    type AssignPermission = {
      menus: number[];
    };
  }
}
