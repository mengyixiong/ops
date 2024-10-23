-- ----------------------------
-- Records of system_menus
-- ----------------------------
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (1, 0, '首页', NULL, 'route.home', 'N', 'home', '/home', 'view.home', 'material-symbols:home', 0, NULL, '1', NULL, '2024-10-20 15:15:28', '2024-10-23 21:17:36');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (2, 1, '数据', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'Index.index', '2', NULL, '2024-10-20 15:20:44', '2024-10-20 15:20:44');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (3, 11, '角色管理', NULL, NULL, 'N', 'setting_system_role', '/setting/system/role', 'view.setting_system_role', 'carbon:user-role', 0, '', '1', NULL, '2024-08-21 07:32:24', '2024-08-21 07:32:24');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (4, 3, '添加', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.role.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (5, 3, '修改', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.role.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (6, 3, '删除', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.role.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (7, 11, '菜单管理', NULL, NULL, 'N', 'setting_system_menu', '/setting/system/menu', 'view.setting_system_menu', 'vaadin:menu', 0, '', '1', NULL, '2024-08-21 07:36:51', '2024-08-21 07:36:51');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (8, 7, '添加', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.menu.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (9, 7, '修改', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.menu.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (10, 7, '删除', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.menu.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (11, 24, '管理权限', NULL, 'route.setting_system', 'N', 'setting_system', '/setting/system', 'view.setting_system', 'ic:baseline-manage-accounts', 0, NULL, '1', NULL, '2024-08-21 07:22:49', '2024-10-23 21:19:02');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (12, 11, '用户管理', NULL, NULL, 'N', 'setting_system_admin', '/setting/system/admin', 'view.setting_system_admin', 'raphael:user', 0, '', '1', NULL, '2024-08-21 07:28:16', '2024-08-21 07:28:16');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (13, 12, '添加', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.admin.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (14, 12, '删除', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.admin.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (15, 12, '修改', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.admin.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (16, 3, '列表', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.role.index', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (17, 7, '列表', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.menu.index', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (18, 12, '列表', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.amidn.index', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (19, 11, '主体管理', NULL, NULL, 'N', 'setting_system_company', '/setting/system/company', 'view.setting_system_company', 'raphael:user', 0, '', '1', NULL, '2024-08-21 07:28:16', '2024-08-21 07:28:16');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (20, 19, '添加', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.company.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (21, 19, '删除', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.company.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (22, 19, '修改', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.company.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (23, 19, '列表', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, 'system.company.index', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `sort`, `i18n_key`, `is_hide_menu`, `name`, `path`, `component`, `icon`, `com_id`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (24, 0, '设置', NULL, NULL, 'N', 'setting', '/setting', 'view.setting', 'ant-design:setting-filled', 0, '', '1', NULL, NULL, NULL);

-- ----------------------------
-- Records of system_admin_roles
-- ----------------------------
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (2, 2);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (2, 3);

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



