<?php

namespace app\api\controller;

use app\luser\service\JwtAuth;
use app\luser\service\Access;

use app\luser\model\User as UserModel;
use app\luser\model\Log as LogModel;
use app\luser\model\Config as ConfigModel;
use app\luser\facade\User as UserFacade;

class LuserPassport extends LuserBase
{
    /**
     * 控制器中间件 [登录、注册 不需要鉴权]
     * @var array
     */
    protected $middleware = [
        'app\luser\middleware\Api' => [
            'except' => [
                'login', 
                'register'
            ]
        ],
    ];

    /**
     * 登陆
     *
     * @title 登陆
     * @method POST
     * @request {"username":"username","password":"md5(password)"}
     * @response {"token":"token"}
     * @listorder 10
     *
     * @create 2020-8-22
     * @author deatil
     */
    public function login()
    {
        $username = request()->post('username');
        if (empty($username)) {
            $this->errorJson('账号不能为空');
        }

        $password = request()->post('password');
        if (empty($password)) {
            $this->errorJson('密码不能为空');
        }
        if (strlen($password) != 32) {
            $this->errorJson('用户密码错误');
        }
        
        // 校验用户名密码
        $user = UserModel::where('username|email|phone', $username)
            ->find();
        if (empty($user)) {
            $this->errorJson('帐号错误');
        }
        
        $password2 = UserFacade::encryptPassword($password, $user['salt']); 
        if ($password2 != $user['password']) {
            $this->errorJson('用户密码错误');
        }
        
        if ($user['status'] == 0 
            || $user['is_lock'] == 1
        ) {
            $this->errorJson('用户已被禁用或者不存在');
        }
        
        $accessType = ConfigModel::getNameValue('access_type');
        if ($accessType == 'jwt') {
            // 获取jwt的句柄
            $jwtAuth = JwtAuth::getInstance();
            $token = $jwtAuth->setUid($user['id'])->encode()->getToken();
            if (empty($token)) {
                $this->errorJson('登陆失败');
            }
        } else {
            $token = Access::createToken($user['id']);
            if ($token === false) {
                $this->errorJson('登陆失败');
            }
        }
        
        // 更新信息
        UserModel::where([
            ['id', '=', $user['id']]
        ])
            ->update([
                'last_active' => time(), 
                'last_ip' => request()->ip(),
            ]);
        
        // 记录日志
        LogModel::record([
            'user_id' => $user['id'],
        ]);
        $this->successJson('登录成功', ['token' => $token]);
    }

    /**
     * 注册
     *
     * @title 注册
     * @method POST
     * @request {"username":"username","nickname":"nickname","password":"md5(password)"}
     * @response {"id":"id","username":"username","nickname":"nickname"}
     * @listorder 5
     *
     * @create 2020-8-22
     * @author deatil
     */
    public function register()
    {
        $username = request()->post('username');
        if (empty($username)) {
            $this->errorJson('账号不能为空');
        }

        $nickname = request()->post('nickname');
        if (empty($nickname)) {
            $this->errorJson('昵称不能为空');
        }

        // 密码长度错误
        $password = request()->post('password');
        if (strlen($password) != 32) {
            $this->errorJson('密码长度错误');
        }

        // 防止重复
        $id = UserModel::where([
            ['username', '=', $username]
        ])->find();
        if (!empty($id)) {
            $this->errorJson('账号已被注册');
        }
        
        // 密码
        $passwordinfo = UserFacade::encryptPassword($password); 

        $sex = request()->post('sex', 1);
        
        // 注册入库
        $data = [
            'username' => $username,
            'nickname' => $nickname,
            'password' => $passwordinfo['password'],
            'salt' => $passwordinfo['encrypt'],
            'sex' => $sex,
            'status' => 1,
            'last_active' => time(),
            'last_ip' => request()->ip(),
            'add_time' => time(),
            'add_ip' => request()->ip(),
        ];
        
        $userInfo = UserModel::create($data);
        if ($userInfo === false) {
            $this->errorJson('注册失败');
        }
        
        $this->successJson('注册成功', [
            'id' => $userInfo->id,
            'username' => $username,
            'nickname' => $nickname,
        ]);
    }
}
