<?php

namespace app\luser\service;

use app\luser\model\User as UserModel;

use app\luser\facade\Password as PasswordFacade;

/**
 * 表单构建器
 *
 * @create 2020-8-21
 * @author deatil
 */
class User
{
    /**
     * 用户信息
     * @param type $id 用户名或者用户ID
     * @return array
     */
    public function getInfo($id, $password)
    {
        if (empty($id)) {
            return false;
        }

        $userInfo = UserModel::where([
            'id' => $id,
        ])->whereOr([
            'username' => $id,
        ])->find();
        if (empty($userInfo)) {
            return false;
        }
        
        return $userInfo;
    }
    
    /**
     * 检测密码
     * @param type $identifier 用户名或者用户ID
     * @param type $password 密码
     * @return boolean
     */
    public function checkPassword($id, $password)
    {
        if (empty($id) || empty($password)) {
            return false;
        }

        $userInfo = $this->getInfo($id);
        if ($userInfo === false) {
            return false;
        }
        
        // 密码验证
        $encryptPassword = $this->encryptPassword($password, $userInfo['encrypt']);
        if ($encryptPassword != $userInfo['password']) {
            return false;
        }
        
        return true;
    }

    /**
     * 修改密码
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function changePassword($id = 0, $password = '') 
    {
        if (empty($id) || empty($password)) {
            return false;
        }
        
        // 对密码进行处理 $password为MD5格式
        $passwordinfo = $this->encryptPassword($password); 
        $data = [];
        $data['password'] = $passwordinfo['password'];
        $data['salt'] = $passwordinfo['encrypt'];
        
        $status = UserModel::where([
            'id' => $id,
        ])->update($data);
        
        return $status;
    }
    
    /**
     * 密码加密
     * @param $password
     * @param $encrypt //传入加密串，在修改密码时做认证
     * @return array/password
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function encryptPassword($password, $encrypt = '')
    {
        $salt = config("luser.salt");
        $pwd = PasswordFacade::setSalt($salt)->encrypt($password, $encrypt);
        return $pwd;
    }

}
