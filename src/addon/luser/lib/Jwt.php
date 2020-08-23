<?php

namespace app\luser\lib;

use Lcobucci\JWT\Builder;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\ValidationData;

/**
 * jwt
 *
 * @create 2020-8-22
 * @author deatil
 */
class Jwt
{
    // alg
    private $alg = 'HS256';

    // claim issuer
    private $issuer = '';

    // claim audience
    private $audience = '';

    // secrect
    private $secrect = '';

    // jwt 过期时间
    private $expTime = 3600;

    // 时间内不能访问
    private $notBeforeTime = 10;

    // decode token
    private $decodeToken;
    
    // jwt token
    private $token;

    // claim uid
    private $uid;

    // 设置alg
    public function setAlg($alg)
    {
        $this->alg = $alg;
        return $this;
    }

    // 设置iss
    public function setIss($issuer)
    {
        $this->issuer = $issuer;
        return $this;
    }

    // 设置aud
    public function setAud($audience)
    {
        $this->audience = $audience;
        return $this;
    }

    // 设置tokenId
    public function setTokenId($tokenId)
    {
        $this->tokenId = $tokenId;
        return $this;
    }

    // 设置notBeforeTime
    public function setNotBeforeTime($notBeforeTime)
    {
        if ($notBeforeTime < 0) {
            $notBeforeTime = 0;
        }
        
        $this->notBeforeTime = $notBeforeTime;
        return $this;
    }

    // 设置secrect
    public function setSecrect($secrect)
    {
        $this->secrect = $secrect;
        return $this;
    }

    // 设置expTime
    public function setExpTime($expTime)
    {
        $this->expTime = $expTime;
        return $this;
    }

    // 设置token
    public function setToken($token)
    {
        $this->token = $token;
        return $this;
    }

    // 获取token
    public function getToken()
    {
        return (string) $this->token;
    }

    // 设置uid
    public function setUid($uid)
    {
        $this->uid = $uid;
        return $this;
    }

    // 获取uid
    public function getUid()
    {
        return $this->uid;
    }

    // 编码jwt token
    public function encode()
    {
        $time = time();
        $signer = new Sha256();
        $secrect = new Key($this->secrect);
        $this->token = (new Builder())
            ->setHeader('alg', $this->alg)
            ->setIssuer($this->issuer) // 发布者
            ->setAudience($this->audience) // 接收者
            ->setId($this->tokenId) // 对当前token设置的标识
            ->setIssuedAt($time) // token创建时间
            ->setNotBefore($time + 10) // 多少秒内无法使用
            ->setExpiration($time + $this->expTime) // 过期时间
            ->set('uid', $this->uid)
            ->sign($signer, $secrect)
            ->getToken();

        return $this;
    }

    public function decode()
    {
        if (!$this->decodeToken) {
            // Parses from a string
            $this->decodeToken = (new Parser())->parse((string)$this->token); 
        }
        
        return $this;
    }

    // validate
    public function validate()
    {
        // It will use the current time to validate (iat, nbf and exp)
        $data = new ValidationData(); 
        $data->setIssuer($this->issuer);
        $data->setAudience($this->audience);
        $data->setId($this->tokenId);
        $data->setCurrentTime(time());

        return $this->decodeToken->validate($data);
    }

    // verify token
    public function verify()
    {
        $signer = new Sha256();
        $secrect = new Key($this->secrect);
        return $this->decodeToken->verify($signer, $secrect);
    }

    /**
     * 获取token存储数据
     *
     * @create 2020-8-23
     * @author deatil
     */
    public function getClaim($name = 'uid')
    {
        return $this->decodeToken->getClaim($name);
    }

}
