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
    
    // 模块地址
    'path' => __DIR__,
    
    'need_module' => [],
    
    'event' => [],
    
    'menus' => include __DIR__ . '/menu.php',
);
