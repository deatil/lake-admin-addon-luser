<?php

namespace app\luser\service;

use Lake\Random;

use app\luser\model\Access as AccessModel;
use app\luser\model\Config as ConfigModel;

/**
 * 授权信息
 *
 * @create 2020-8-23
 * @author deatil
 */
class Access
{
    /**
     * 创建token
     *
     * @create 2020-8-23
     * @author deatil
     */
    public static function createToken($userId = '')
    {
        if (empty($userId)) {
            return '';
        }
        
        // uuid类token
        $token = Random::uuid();
        
        // 过期时间
        $expireTime = config('luser.access_exptime');
        if (empty($expireTime)) {
            $expireTime = ConfigModel::getNameValue('access_exptime');
        }
        
        $status = AccessModel::create([
            'user_id' => $userId,
            'token' => $token,
            'expire_time' => time() + (int) $expireTime,
            'add_time' => time(),
            'add_ip' => request()->ip(),
        ]);
        if ($status === false) {
            return false;
        }
        
        return $token;
    }

    /**
     * 获取token
     *
     * @create 2020-8-23
     * @author deatil
     */
    public static function getToken($userId = '')
    {
        if (empty($userId)) {
            return false;
        }
        
        $access = AccessModel::where([
            'user_id' => $userId,
        ])->find();
        if (empty($access)) {
            return false;
        }
        if ($access['is_logout'] == 1) {
            return false;
        }
        if ($access['expire_time'] < time()) {
            return false;
        }
        
        return $access['token'];
    }

    /**
     * 检测token
     *
     * @create 2020-8-23
     * @author deatil
     */
    public static function checkToken($token = '')
    {
        if (empty($token)) {
            return false;
        }
        
        $access = AccessModel::where([
            'token' => $token,
        ])->find();
        if (empty($access)) {
            return false;
        }
        
        if ($access['is_logout'] == 1) {
            return false;
        }
        
        if ($access['expire_time'] < time()) {
            return false;
        }
        
        return $access;
    }
    
}