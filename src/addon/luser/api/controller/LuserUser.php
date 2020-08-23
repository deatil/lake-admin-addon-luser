<?php

namespace app\api\controller;

use app\luser\model\User as UserModel;
use app\luser\facade\User as UserFacade;

class LuserUser extends LuserBase
{
    /**
     * 我的信息
     *
     * @title 我的信息
     * @method GET
     *
     * @create 2020-8-22
     * @author deatil
     */
    public function myInfo()
    {
        $uid = env('uid');
        $user = UserModel::field("
                username,
                nickname,
                avatar,
                sex,
                birthday,
                province,
                city,
                district,
                last_active
            ")
            ->where('id', $uid)
            ->find();
        $user['avatar'] = lake_get_file_path($user['avatar']);
        
        if (empty($user)) {
            $this->errorJson('帐号错误');
        }
        
        return $this->successJson('获取成功', $user);
    }

    /**
     * 修改密码
     *
     * @create 2020-8-22
     * @author deatil
     */
    public function changePasssword()
    {
        // 密码长度错误
        $oldPassword = request()->post('oldPassword');
        if (strlen($oldPassword) != 32) {
            $this->errorJson('旧密码错误');
        }

        // 密码长度错误
        $newPassword = request()->post('newPassword');
        if (strlen($newPassword) != 32) {
            $this->errorJson('新密码错误');
        }

        $newPassword2 = request()->post('newPassword2');
        if (strlen($newPassword2) != 32) {
            $this->errorJson('确认密码错误');
        }

        if ($newPassword != $newPassword2) {
            $this->errorJson('两次密码输入不一致');
        }

        $uid = env('uid');
        $user = UserModel::where('id', $uid)
            ->find();
        if (empty($user)) {
            $this->errorJson('帐号错误');
        }
        
        $password2 = UserFacade::encryptPassword($oldPassword, $user['salt']); 
        if ($password2 != $user['password']) {
            $this->errorJson('用户密码错误');
        }

        // 新密码
        $newPasswordInfo = UserFacade::encryptPassword($newPassword); 

        // 更新信息
        $status = UserModel::where('id', $user['id'])
            ->update([
                'password' => $newPasswordInfo['password'],
                'salt' => $newPasswordInfo['encrypt'],
            ]);
        if ($status === false) {
            $this->errorJson('密码修改失败');
        }
        
        $this->successJson('密码修改成功');
    }

}
