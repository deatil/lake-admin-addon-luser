<?php

namespace app\luser\model;

use think\Model;
use think\facade\Cache;

/*
 * Config 模型
 *
 * @create 2020-8-23
 * @author deatil
 */
class Config extends Model
{
    protected $name = 'luser_config';
    
    /*
     * 获取列表
     *
     * @create 2020-8-23
     * @author deatil
     */
    public static function getList()
    {
        $setting = Cache::get("luser_config");
        if (!$setting) {
            $config = self::column('name,value');
            
            $setting = [];
            if (!empty($config)) {
                foreach ($config as $val) {
                    $setting[$val['name']] = $val['value'];
                }
            }
            
            Cache::set("luser_config", $setting);
        }
        
        return $setting;
    }
    
    /*
     * 获取数据
     *
     * @create 2020-8-23
     * @author deatil
     */
    public static function getNameValue($name)
    {
        $value = self::where([
            'name' => $name,
        ])->value('value');
        
        return $value;
    }
    
}
