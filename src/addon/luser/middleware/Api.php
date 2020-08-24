<?php

namespace app\luser\middleware;

use Closure;

use think\Response;
use think\exception\HttpResponseException;
use think\facade\Env;

use lake\module\traits\Json as JsonTrait;

use app\luser\service\JwtAuth;
use app\luser\service\Access;

use app\luser\model\Config as ConfigModel;

class Api
{
    use JsonTrait;
    
    public function handle($request, Closure $next)
    {
        $accessType = ConfigModel::getNameValue('access_type');
        if ($accessType == 'jwt') {
            $this->jwtCheck();
        } else {
            $this->tokenCheck();
        }

        return $next($request);
    }
    
    /*
     * toke验证
     *
     * @create 2020-8-23
     * @author deatil
     */
    protected function tokenCheck()
    {
        $token = request()->header('token');
        if (!$token) {
            $this->errorJson('token不能为空');
        }
        
        $decodeToken = Access::checkToken($token);
        if ($decodeToken === false) {
            $this->errorJson('token已过期');
        }
        
        $uid = $decodeToken['user_id'];
        Env::set([
            'uid' => $uid,
        ]);
    }
    
    /*
     * jwt验证
     *
     * @create 2020-8-23
     * @author deatil
     */
    protected function jwtCheck()
    {
        $token = request()->header('token');
        if (!$token) {
            $this->errorJson('token不能为空');
        }
        
        if (count(explode('.', $token)) <> 3) {
            $this->errorJson('token格式错误');
        }
        
        $jwtAuth = JwtAuth::getInstance();
        $jwtAuth->setToken($token)->decode();
        if (!($jwtAuth->validate() && $jwtAuth->verify())) {
            $this->errorJson('token已过期');
        }
        
        $uid = $jwtAuth->getClaim('uid');
        Env::set([
            'uid' => $uid,
        ]);
    }

}
