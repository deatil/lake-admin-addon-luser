<?php

namespace app\luser\model;

use think\Model;

/**
 * 登陆日志表
 *
 * @create 2020-8-21
 * @author deatil
 */
class Log extends Model
{
    protected $name = 'luser_log';
    
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
     * 日志用户
     *
     * @create 2020-8-23
     * @author deatil
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    
    /**
     * 记录日志
     *
     * @create 2020-8-23
     * @author deatil
     */
    public static function record($data = [])
    {
        $data = array_merge([
            'login_time' => time(),
            'login_ip' => request()->ip(),
            'login_useragent' => request()->server('HTTP_USER_AGENT'),
            'login_referer' => request()->server('HTTP_REFERER'),
            'add_time' => time(),
            'add_ip' => request()->ip(),
        ], $data);
        self::create($data);
    }

}