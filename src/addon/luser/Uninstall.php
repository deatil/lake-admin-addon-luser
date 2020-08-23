<?php

namespace app\luser;

use lake\Module;

/**
 * 卸载脚本
 *
 * @create 2019-11-3
 * @author deatil
 */
class Uninstall
{
    // 卸载
    public function run()
    {
        $Module = new Module();
        
        // 清除旧数据
        if (request()->param('clear') == 1) {
            // 卸载数据库
            $runSqlStatus = $Module->runSQL(__DIR__ . "/install/uninstall.sql");
            if (!$runSqlStatus) {
                return false;
            }
        }
        
        return true;
    }

}
