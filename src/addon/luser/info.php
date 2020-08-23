<?php

return array(
    'module' => 'luser',
    'name' => '用户系统',
    'introduce' => '用户系统模块',
    'author' => 'deatil',
    'authorsite' => 'https://github.com/deatil',
    'authoremail' => 'deatil@github.com',
    'version' => '1.0.3',
    'adaptation' => '2.0.2',
    'sign' => '7a234fc129f2046ffc33dbfa4d153c91',
    
    // 模块地址
    'path' => __DIR__,
    
    'need_module' => [],
    
    'event' => [],
    
    'menus' => include __DIR__ . '/menu.php',
    
    'tables' => [
        'luser_config',
        'luser_user',
        'luser_access',
        'luser_log',
    ],
);
