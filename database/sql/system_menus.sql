-- ----------------------------
-- Records of system_menus
-- ----------------------------
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (1, 0, '首页', NULL, 'route.home', 'N', 'home', '/home', 'view.home', 'material-symbols:home', '[]', NULL, '1', NULL, '2024-10-20 15:15:28', '2024-10-23 21:17:36');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (2, 1, '数据', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'Index.index', '2', NULL, '2024-10-20 15:20:44', '2024-10-20 15:20:44');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (3, 11, '角色管理', NULL, NULL, 'N', 'setting_system_role', '/setting/system/role', 'view.setting_system_role', 'carbon:user-role', '[]', '', '1', NULL, '2024-08-21 07:32:24', '2024-08-21 07:32:24');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (4, 3, '添加', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.role.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (5, 3, '修改', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.role.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (6, 3, '删除', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.role.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (7, 11, '菜单管理', NULL, NULL, 'N', 'setting_system_menu', '/setting/system/menu', 'view.setting_system_menu', 'vaadin:menu', '[]', '', '1', NULL, '2024-08-21 07:36:51', '2024-08-21 07:36:51');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (8, 7, '添加', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.menu.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (9, 7, '修改', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.menu.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (10, 7, '删除', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.menu.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (11, 24, '管理权限', NULL, 'route.setting_system', 'N', 'setting_system', '/setting/system', 'view.setting_system', 'ic:baseline-manage-accounts', '[]', NULL, '1', NULL, '2024-08-21 07:22:49', '2024-10-23 21:19:02');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (12, 11, '用户管理', NULL, NULL, 'N', 'setting_system_admin', '/setting/system/admin', 'view.setting_system_admin', 'raphael:user', '[]', '', '1', NULL, '2024-08-21 07:28:16', '2024-08-21 07:28:16');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (13, 12, '添加', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.admin.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (14, 12, '删除', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.admin.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (15, 12, '修改', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.admin.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (16, 3, '列表', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.role.index', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (17, 7, '列表', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.menu.index', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (18, 12, '列表', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.admin.index', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (19, 11, '主体管理', NULL, 'route.setting_system_company', 'N', 'setting_system_company', '/setting/system/company', 'view.setting_system_company', 'weui:photo-wall-filled', '[]', NULL, '1', NULL, '2024-08-21 07:28:16', '2024-10-30 20:00:47');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (20, 19, '添加', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.company.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (21, 19, '删除', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.company.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (22, 19, '修改', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.company.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (23, 19, '列表', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.company.index', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (24, 0, '系统设置', NULL, 'route.setting', 'N', 'setting', '/setting', 'view.setting', 'ant-design:setting-filled', '[]', NULL, '1', NULL, '2024-08-21 07:30:30', '2024-10-30 17:02:47');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (25, 0, '财务中心', NULL, 'route.finance', 'N', 'finance', '/finance', 'view.finance', 'carbon:finance', '[]', NULL, '1', NULL, '2024-10-24 11:13:07', '2024-10-24 11:13:07');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (26, 25, '基础资料', NULL, 'route.finance_basic-data', 'N', 'finance_basic-data', '/finance/basic-data', 'view.finance_basic-data', 'fluent:data-usage-edit-20-filled', '[]', NULL, '1', NULL, '2024-10-24 11:19:00', '2024-10-24 11:19:00');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (27, 26, '会计科目', NULL, 'route.finance_basic-data_subject', 'N', 'finance_basic-data_subject', '/finance/basic-data/subject', 'view.finance_basic-data_subject', 'carbon:account', '[]', NULL, '1', NULL, '2024-10-24 11:30:38', '2024-10-24 11:45:22');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (28, 0, '仓储中心', NULL, 'route.warehouse', 'N', 'warehouse', '/warehouse', 'view.warehouse', 'streamline:warehouse-1-solid', '[2, 1]', NULL, '1', NULL, '2024-10-24 15:55:48', '2024-10-24 17:06:27');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (29, 0, '业务中心', NULL, 'route.business', 'N', 'business', '/business', 'view.business', 'mdi:business-outline', '[2, 3, 1]', NULL, '1', NULL, '2024-10-24 15:57:32', '2024-10-24 15:57:32');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (30, 28, '资料', NULL, 'route.warehouse_data', 'N', 'warehouse_data', '/warehouse/data', 'view.warehouse_data', 'icon-park-twotone:data-lock', '[1, 2, 3]', NULL, '1', NULL, '2024-10-24 16:17:08', '2024-10-24 17:06:46');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (31, 30, '物料', NULL, 'route.warehouse_data_material', 'N', 'warehouse_data_material', '/warehouse/data/material', 'view.warehouse_data_material', 'fluent-mdl2:product-list', '[2, 3, 1]', NULL, '1', NULL, '2024-10-24 16:17:46', '2024-10-24 17:06:56');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (32, 30, '仓库', NULL, 'route.warehouse_data_warehouse', 'N', 'warehouse_data_warehouse', '/warehouse/data/warehouse', 'view.warehouse_data_warehouse', 'ph:warehouse-bold', '[1]', NULL, '1', NULL, '2024-10-24 16:19:18', '2024-10-24 17:07:00');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (33, 29, '业务单据', NULL, 'route.business_orders', 'N', 'business_orders', '/business/orders', 'view.business_orders', 'lets-icons:order', '[1, 2]', NULL, '1', NULL, '2024-10-24 16:21:17', '2024-10-24 16:21:17');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (34, 33, '海运出口', NULL, 'route.business_orders_sea-export', 'N', 'business_orders_sea-export', '/business/orders/sea-export', 'view.business_orders_sea-export', 'hugeicons:boat', '[1, 2, 3]', NULL, '1', NULL, '2024-10-24 16:24:57', '2024-10-24 16:24:57');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (35, 33, '海运进口', NULL, 'route.business_orders_sea-import', 'N', 'business_orders_sea-import', '/business/orders/sea-import', 'view.business_orders_sea-import', 'hugeicons:ferry-boat', '[1, 2]', NULL, '1', NULL, '2024-10-24 16:25:51', '2024-10-24 16:25:51');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (36, 37, '付款单', NULL, 'route.warehouse_payment-order', 'N', 'warehouse_payment-order', '/warehouse/payment-order', 'view.warehouse_payment-order', 'fluent:payment-16-regular', '[]', NULL, '1', NULL, '2024-10-24 16:36:22', '2024-10-24 16:39:33');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (37, 28, '资金', NULL, 'route.warehouse_funds', 'N', 'warehouse_funds', '/warehouse/funds', 'view.warehouse_funds', 'icon-park-outline:funds', '[]', NULL, '1', NULL, '2024-10-24 16:39:22', '2024-10-24 16:39:22');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (38, 37, '收款单', NULL, 'route.warehouse_funds_receiving-order', 'N', 'warehouse_funds_receiving-order', '/warehouse/funds/receiving-order', 'view.warehouse_funds_receiving-order', 'ant-design:money-collect-outlined', '[1, 2]', NULL, '1', NULL, '2024-10-24 16:41:03', '2024-10-24 16:43:36');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (39, 3, '分配权限', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.role.assign-permission', '2', NULL, '2024-10-25 17:27:26', '2024-10-25 17:27:26');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (40, 3, '获取所有角色', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.role.get-roles', '2', NULL, '2024-10-25 17:31:22', '2024-10-25 17:31:22');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (41, 7, '获取所有菜单和权限', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.role.get-menus-and-permissions', '2', NULL, '2024-10-25 17:32:24', '2024-10-25 17:32:24');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (42, 7, '获取所有菜单', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '[]', 'system.role.get-all-menus', '2', NULL, '2024-10-25 17:34:42', '2024-10-25 17:34:42');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (43, 19, '获取所有主体', NULL, 'route.setting_system_company', NULL, NULL, NULL, NULL, NULL, '[]', 'system.role.get-all-companies', '2', NULL, '2024-10-25 17:38:40', '2024-10-25 17:38:40');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (45, 24, '工具', NULL, 'route.setting_tool', 'N', 'setting_tool', '/setting/tool', 'view.setting_tool', 'ant-design:tool-twotone', '[]', NULL, '1', NULL, '2024-10-30 19:14:36', '2024-10-30 19:14:36');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (46, 45, '代码生成', NULL, 'route.setting_tool_generate-record', 'N', 'setting_tool_generate-record', '/setting/tool/generate-record', 'view.setting_tool_generate-record', 'ant-design:file-add-outlined', '[]', NULL, '1', NULL, '2024-10-30 19:16:17', '2024-10-30 19:19:36');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (48, 26, '币种管理', NULL, 'route.finance_basic-data_currency', 'N', 'finance_basic-data_currency', '/finance/basic-data/currency', 'view.finance_basic-data_currency', 'heroicons:document-currency-yen-solid', '[]', NULL, '1', NULL, '2024-10-30 20:01:58', '2024-10-30 20:01:58');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (49, 26, '费用项目', NULL, 'route.finance_basic-data_cost-item', 'N', 'finance_basic-data_cost-item', '/finance/basic-data/cost-item', 'view.finance_basic-data_cost-item', 'ant-design:account-book-filled', '[]', NULL, '1', NULL, '2024-10-30 20:03:26', '2024-10-30 20:03:26');

-- ----------------------------
-- Records of system_admin_roles
-- ----------------------------
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (2, 2);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (2, 3);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (3, 3);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (3, 5);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (4, 2);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (5, 3);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (6, 4);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (7, 2);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (9, 3);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (9, 4);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (13, 5);

-- ----------------------------
-- Records of system_role_menus
-- ----------------------------
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 1);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 2);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 3);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 4);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 5);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 6);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 7);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 8);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 9);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 10);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 11);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 12);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 13);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 14);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 15);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 16);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 17);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 18);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 19);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 20);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 21);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 22);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 23);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 24);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 1);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 2);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 24);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 11);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 3);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 4);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 5);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 6);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 16);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 7);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 8);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 9);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 10);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 17);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 12);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 13);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 14);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 15);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 18);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 19);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 20);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 21);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 22);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 23);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 25);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 26);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 27);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 28);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 30);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 31);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 32);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 37);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 36);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 38);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 29);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 33);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 34);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (1, 35);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 2);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 1);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 2);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 1);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 24);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 11);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 3);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 7);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 8);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 9);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 10);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 17);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 12);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 19);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 1);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 2);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 25);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 26);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 27);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 29);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (5, 41);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 33);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 34);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 35);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 4);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 5);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 6);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 16);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (4, 39);


-- ----------------------------
-- Records of system_companies
-- ----------------------------
INSERT INTO `ops`.`system_companies` (`id`, `name`, `is_default`, `abb`, `created_at`, `updated_at`) VALUES (1, '深圳市瑞秋国际物流有限公司', 'Y', '瑞秋物流', '2024-10-24 21:01:42', '2024-10-24 21:07:49');
INSERT INTO `ops`.`system_companies` (`id`, `name`, `is_default`, `abb`, `created_at`, `updated_at`) VALUES (2, '深圳市佰亿龙供应链管理有限公司', 'N', '佰亿龙', '2024-10-24 21:08:10', '2024-10-24 21:08:10');
INSERT INTO `ops`.`system_companies` (`id`, `name`, `is_default`, `abb`, `created_at`, `updated_at`) VALUES (3, '深圳市芯仓科技有限公司', 'N', '芯仓科技', '2024-10-24 21:08:30', '2024-10-24 21:08:30');


-- ----------------------------
-- Records of system_admin_companies
-- ----------------------------
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (3, 2);
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (3, 1);
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (4, 1);
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (4, 2);
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (4, 3);
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (5, 1);
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (6, 2);
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (7, 3);
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (9, 1);
INSERT INTO `ops`.`system_admin_companies` (`admin_id`, `company_id`) VALUES (9, 2);




