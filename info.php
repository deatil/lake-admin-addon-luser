<?php

return array(
    'module' => 'luser',
    'name' => '用户系统',
    'introduce' => '用户系统模块',
    'author' => 'deatil',
    'authorsite' => 'https://github.com/deatil',
    'authoremail' => 'deatil@github.com',
    'version' => '1.0.5',
    'adaptation' => '2.3.27',
    
    'path' => __DIR__,
    'need_module' => [],
    'event' => [],
    'menus' => include __DIR__ . '/menu.php',
);
