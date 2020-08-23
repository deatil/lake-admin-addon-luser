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
        
        $this->setAlg(config('luser.jwt_alg', $config['jwt_alg']));
        $this->setIss(config('luser.jwt_iss', $config['jwt_iss']));
        $this->setAud(config('luser.jwt_aud', $config['jwt_aud']));
        $this->setTokenId(config('luser.jwt_tokenid', $config['jwt_tokenid']));
        $this->setSecrect(config('luser.jwt_secrect', $config['jwt_secrect']));
        $this->setExpTime(config('luser.jwt_exptime', $config['jwt_exptime']));
        $this->setNotBeforeTime(config('luser.jwt_notbeforetime', $config['jwt_notbeforetime']));
    }

    // 私有化clone函数
    private function __clone()
    {}

    // 编码jwt token
    public function encode()
    {
        return parent::encode();
    }

    public function decode()
    {
        return parent::decode();
    }

    // validate
    public function validate()
    {
        return parent::validate();
    }

    // verify token
    public function verify()
    {
        return parent::verify();
    }

}
