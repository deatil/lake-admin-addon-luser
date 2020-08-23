<?php

/*
 * 菜单
 *
 * @create 2020-8-20
 * @author deatil
 */
return [
    [
        "route" => "admin/LuserUser/index",
        "method" => "GET",
        "type" => 1,
        "is_menu" => 1,
        "title" => "用户系统",
        "icon" => "icon-people",
        "tip" => "",
        "listorder" => 125,
        "child" => [
            [
                "route" => "admin/LuserSetting/index",
                "method" => "GET",
                "type" => 1,
                "is_menu" => 1,
                "title" => "设置",
                "icon" => "icon-setup",
                "listorder" => 5,
                "child" => [
                    [
                        "route" => "admin/LuserSetting/index",
                        "method" => "POST",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "设置",
                    ],
                ],
            ],
            [
                "route" => "admin/LuserUser/index",
                "method" => "GET",
                "type" => 1,
                "is_menu" => 1,
                "title" => "用户列表",
                "icon" => "icon-huiyuan",
                "listorder" => 15,
                "child" => [
                    [
                        "route" => "admin/LuserUser/index",
                        "method" => "POST",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "用户列表",
                    ],
                    [
                        "route" => "admin/LuserUser/add",
                        "method" => "GET",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "添加用户",
                        "child" => [
                            [
                                "route" => "admin/LuserUser/add",
                                "method" => "POST",
                                "type" => 1,
                                "is_menu" => 0,
                                "title" => "添加用户",
                            ],
                        ],
                    ],
                    [
                        "route" => "admin/LuserUser/edit",
                        "method" => "GET",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "编辑用户",
                        "child" => [
                            [
                                "route" => "admin/LuserUser/edit",
                                "method" => "POST",
                                "type" => 1,
                                "is_menu" => 0,
                                "title" => "编辑用户",
                            ],
                        ],
                    ],
                    [
                        "route" => "admin/LuserUser/detail",
                        "method" => "GET",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "用户详情",
                    ],
                    [
                        "route" => "admin/LuserUser/delete",
                        "method" => "POST",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "删除用户",
                    ],
                    [
                        "route" => "admin/LuserUser/state",
                        "method" => "POST",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "用户状态",
                    ],
                ],
            ],
            [
                "route" => "admin/LuserAccess/index",
                "method" => "GET",
                "type" => 1,
                "is_menu" => 1,
                "title" => "用户授权",
                "icon" => "icon-shiyongwendang",
                "listorder" => 25,
                "child" => [
                    [
                        "route" => "admin/LuserAccess/index",
                        "method" => "POST",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "授权列表",
                    ],
                    [
                        "route" => "admin/LuserAccess/logout",
                        "method" => "POST",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "授权登出",
                    ],
                    [
                        "route" => "admin/LuserAccess/delete",
                        "method" => "POST",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "删除授权",
                    ],
                ],
            ],
            [
                "route" => "admin/LuserLog/index",
                "method" => "GET",
                "type" => 1,
                "is_menu" => 1,
                "title" => "登陆日志",
                "icon" => "icon-rizhi",
                "listorder" => 35,
                "child" => [
                    [
                        "route" => "admin/LuserLog/index",
                        "method" => "POST",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "日志列表",
                    ],
                    [
                        "route" => "admin/LuserLog/detail",
                        "method" => "GET",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "日志详情",
                    ],
                    [
                        "route" => "admin/LuserLog/clear",
                        "method" => "POST",
                        "type" => 1,
                        "is_menu" => 0,
                        "title" => "清除日志",
                    ],
                ],
            ],
        ],
    ],
];
