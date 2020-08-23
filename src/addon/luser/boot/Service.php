<?php

namespace app\luser\boot;

use think\Service as BaseService;

/**
 * 服务
 *
 * @create 2020-8-23
 * @author deatil
 */
class Service extends BaseService
{
    public function boot()
    {
        $this->app->event->listen('lake_admin_module', function () {
            $info_file = dirname(__DIR__)
                . DIRECTORY_SEPARATOR . 'info.php';
            if (file_exists($info_file)) {
                $info = include $info_file;
            } else {
                $info = [];
            }
            
            return $info;
        });
    }
    
}
