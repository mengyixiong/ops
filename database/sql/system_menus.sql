-- ----------------------------
-- Records of system_menus
-- ----------------------------
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (1, 0, '系统管理', 'System', '/system', 'ant-design:setting-filled', 'system', '1', NULL, '2024-08-21 07:22:49', '2024-08-21 07:22:49');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (2, 1, '用户管理', 'SystemAdmin', '/system/admin/index', 'raphael:user', 'system.admin.index', '1', NULL, '2024-08-21 07:28:16', '2024-08-21 07:28:16');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (4, 2, '添加', NULL, '/system/admin/store', 'Edit', 'system.admin.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (5, 2, '修改', NULL, '/system/admin/update', 'Edit', 'system.admin.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (6, 2, '删除', NULL, '/system/admin/delete', 'Delete', 'system.admin.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (7, 1, '角色管理', 'SystemRole', '/system/role/index', 'carbon:user-role', 'system.role.index', '1', NULL, '2024-08-21 07:32:24', '2024-08-21 07:32:24');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (9, 7, '添加', NULL, '/system/role/store', 'Edit', 'system.role.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (10, 7, '修改', NULL, '/system/role/update', 'Edit', 'system.role.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (11, 7, '删除', NULL, '/system/role/delete', 'Delete', 'system.role.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (12, 1, '菜单管理', 'SystemMenu', '/system/menu/index', 'vaadin:menu', 'system.menu.index', '1', NULL, '2024-08-21 07:36:51', '2024-08-21 07:36:51');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (14, 12, '添加', NULL, '/system/menu/store', 'Edit', 'system.menu.store', '2', NULL, '2024-08-21 07:29:06', '2024-08-21 07:29:06');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (15, 12, '修改', NULL, '/system/menu/update', 'Edit', 'system.menu.update', '2', NULL, '2024-08-21 07:30:30', '2024-08-21 07:30:30');
INSERT INTO `ops`.`system_menus` (`id`, `pid`, `title`, `name`, `path`, `icon`, `permission`, `type`, `deleted_at`, `created_at`, `updated_at`) VALUES (16, 12, '删除', NULL, '/system/menu/delete', 'Delete', 'system.menu.delete', '2', NULL, '2024-08-21 07:31:37', '2024-08-21 07:31:37');

-- ----------------------------
-- Records of system_admin_roles
-- ----------------------------
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (1, 2);
INSERT INTO `ops`.`system_admin_roles` (`admin_id`, `role_id`) VALUES (1, 3);

-- ----------------------------
-- Records of system_role_menus
-- ----------------------------
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 12);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 14);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 15);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 16);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 7);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 9);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 10);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 11);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (3, 1);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 1);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 2);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 4);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 5);
INSERT INTO `ops`.`system_role_menus` (`role_id`, `menu_id`) VALUES (2, 6);

