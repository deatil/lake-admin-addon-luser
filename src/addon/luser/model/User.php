<?php

namespace app\luser\model;

use think\Model;

/**
 * 用户模型
 *
 * @create 2020-8-20
 * @author deatil
 */
class User extends Model
{
    protected $name = 'luser_user';
    
    // 设置当前模型对应的主键名
    protected $pk = 'id';
    
    // 时间字段取出后的默认时间格式
    protected $dateFormat = false;

    public function getStatusTextAttr($value, $data) 
    {
        $status = array(
            0 => '禁用',
            1 => '启用',
        );
        return $status[$data['status']];
    }
    
    /**
     * 授权信息列表
     *
     * @create 2020-8-20
     * @author deatil
     */
    public function accesses()
    {
        return $this->hasMany(Access::class, 'user_id', 'id');
    }
    
    /**
     * 日志列表
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function logs()
    {
        return $this->hasMany(Log::class, 'user_id', 'id');
    }
    
    /**
     * 密码
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function password()
    {
        return $this->password;
    }

}