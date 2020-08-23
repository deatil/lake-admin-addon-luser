<?php

namespace app\luser\model;

use think\Model;

/**
 * 授权信息表
 *
 * @create 2020-8-20
 * @author deatil
 */
class Access extends Model
{
    protected $name = 'luser_access';
    
    // 设置当前模型对应的主键名
    protected $pk = 'id';
    
    // 时间字段取出后的默认时间格式
    protected $dateFormat = false;

    public static function onBeforeInsert($model)
    {
        $id = md5(mt_rand(10000, 99999) . time() . mt_rand(10000, 99999));
        $model->setAttr('id', $id);
    }
    
    /**
     * token
     *
     * @create 2020-8-23
     * @author deatil
     */
    public function token()
    {
        return $this->token;
    }
    
    /**
     * 授权用户
     *
     * @create 2020-8-23
     * @author deatil
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

}