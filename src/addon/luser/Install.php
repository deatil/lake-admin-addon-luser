<?php

namespace app\luser;

use lake\Random;
use lake\admin\module\Module;

/**
 * 安装脚本
 *
 * @create 2020-8-20
 * @author deatil
 */
class Install
{
    /**
     * 安装完回调
     * @return boolean
     */
    public function end()
    {    
        $Module = new Module();
        
        // 清除旧数据
        if (request()->param('clear') == 1) {
            // 
        }
        
        // 安装数据库
        $runSqlStatus = $Module->runSQL(__DIR__ . "/install/install.sql");
        if (!$runSqlStatus) {
            return false;
        }
        
        // 更新配置
        $configFile = __DIR__ . "/install/luser.php";
        if (file_exists($configFile)) {
            $saltStr = Random::alnum(12);
            $secrectStr = Random::alnum(8);
            $configInfo = file_get_contents($configFile);
            
            $newConfigInfo = str_replace([
                '{{salt}}',
                '{{secrect}}',
            ], [
                $saltStr,
                $secrectStr,
            ], $configInfo);
            $newConfigFile = __DIR__ . "/global/config/luser.php";
            file_put_contents($newConfigFile, $newConfigInfo);
        }
        
        return true;
    }

}
