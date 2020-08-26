<?php

namespace app\luser\service;

use app\luser\lib\Jwt;
use app\luser\model\Config as ConfigModel;

/**
 * jwt验证
 *
 * @create 2020-8-22
 * @author deatil
 */
class JwtAuth extends Jwt
{
    // 单例模式JwtAuth句柄
    private static $instance;

    // 获取JwtAuth的句柄
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    // 私有化构造函数
    private function __construct()
    {
        $config = ConfigModel::getList();
        
        $configInfo = config('luser');
        $config = array_merge($configInfo, $config);

        $this->setAlg($config['jwt_alg']);
        $this->setIss($config['jwt_iss']);
        $this->setAud($config['jwt_aud']);
        $this->setSub($config['jwt_sub']);
        $this->setJti($config['jwt_jti']);
        $this->setSecrect($config['jwt_secrect']);
        $this->setExpTime(intval($config['jwt_exptime']));
        $this->setNotBeforeTime($config['jwt_notbeforetime']);
    }

    // 私有化clone函数
    private function __clone()
    {}
}
