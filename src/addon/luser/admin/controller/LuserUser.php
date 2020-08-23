<?php

namespace app\admin\controller;

use app\luser\model\User as UserModel;

use app\luser\validate\User as UserValidate;
use app\luser\facade\User as UserFacade;

/*
 * 用户列表
 *
 * @create 2020-8-21
 * @author deatil
 */
class LuserUser extends LuserBase
{
    
    /*
     * 首页
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function index()
    {
        if (request()->isPost()) {
            $key = $this->request->post('key');
            
            $where = [];
            $where[] = ['username|nickname|email|phone', 'like', "%".$key."%"];
            
            $list = UserModel::field('*')
                ->where($where)
                ->order('id ASC, add_time DESC')
                ->select()
                ->toArray();
                
            $count = UserModel::field('id')
                ->where($where)
                ->count();
            
            $data = [
                'code' => 0,
                'msg' => '获取成功!',
                'data' => $list,
                'count' => $count
            ];
            
            return json($data);
        } else {
            return $this->fetch();
        }
    }
    
    /**
     * 添加
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function add()
    {
        if (request()->isPost()) {
            $post = input('post.');
            
            $result = $this->validate($post, UserValidate::class);
            if (true !== $result) {
                return $this->error($result);
            }
            
            $data = [
                'username' => trim($post['username']),
                'nickname' => trim($post['nickname']),
                'password' => '',
                'status' => (isset($post['status']) && $post['status'] == 1) ? 1 : 0,
                'last_active' => time(),
                'last_ip' => request()->ip(),
                'add_time' => time(),
                'add_ip' => request()->ip(),
            ];

            $ststus = UserModel::insert($data);
            if ($ststus === false) {
                return $this->error('添加失败!');
            }

            return $this->success('添加成功!');
        } else {
            return $this->fetch();
        }
    }
    
    /**
     * 编辑
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function edit($id = '')
    {
        if (request()->isPost()) {
            $post = input('post.');
            
            $id = $post['id'];
            
            $data = [
                'username' => trim($post['username']),
                'nickname' => trim($post['nickname']),
                'email' => trim($post['email']),
                'avatar' => trim($post['avatar']),
                'sex' => (isset($post['sex']) && $post['sex'] == 2) ? 2 : 1,
                'birthday' => strtotime($post['birthday']),
                'email' => trim($post['email']),
                'email_validated' => (isset($post['email_validated']) && $post['email_validated'] == 1) ? 1 : 0,
                'phone' => trim($post['phone']),
                'phone_validated' => (isset($post['phone_validated']) && $post['phone_validated'] == 1) ? 1 : 0,
                'qq' => trim($post['qq']),
                'province' => trim($post['province']),
                'city' => trim($post['city']),
                'district' => trim($post['district']),
                'is_lock' => (isset($post['is_lock']) && $post['is_lock'] == 1) ? 1 : 0,
                'remark' => trim($post['remark']),
                'status' => (isset($post['status']) && $post['status'] == 1) ? 1 : 0,
                'edit_time' => time(),
                'edit_ip' => request()->ip(),
            ];

            $status = UserModel::where([
                'id' => $id,
            ])->update($data);
            if ($status === false) {
                return $this->error('修改失败!');
            }
            
            return $this->success('修改成功!');
        } else {
            $info = UserModel::where([
                'id' => $id,
            ])->field("*")
            ->find();
            $this->assign('info', $info);
            
            return $this->fetch();
        }
    }
    
    /*
     * 更改状态
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function state()
    {
        $id = input('post.id');
        $status = input('post.status');
        
        $status = UserModel::where([
            'id' => $id,
        ])->update([
            'status' => $status,
        ]);
        if ($status === false) {
            return $this->error('设置失败!');
        }
        
        return $this->success('设置成功!');
    }
    
    /**
     * 详情
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function detail($id = '')
    {
        if (!request()->isGet()) {
            return $this->error('请求错误');
        }
        
        if (empty($id)) {
            return $this->error('ID不能为空');
        }
        
        $data = UserModel::where([
            'id' => $id,
        ])->field("*")
        ->find();
        if (empty($data)) {
            return $this->error('数据不存在');
        }
        
        $this->assign('data', $data);
        
        return $this->fetch();
    }

    /**
     * 删除
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function delete()
    {
        if (!request()->isPost()) {
            return $this->error('请求错误!');
        }
        
        $id = input('id');
        if (empty($id)) {
            return $this->error('ID错误!');
        }
        
        $status = UserModel::where([
            'id' => $id,
        ])->delete();
        if ($status === false) {
            return $this->error('删除失败!');
        }
        
        return $this->success('删除成功!', (string) url('index'));
    }
    
    /**
     * 更新密码
     *
     * @create 2020-8-21
     * @author deatil
     */
    public function password()
    {
        if ($this->request->isPost()) {
            $post = $this->request->post('');
            
            if (empty($post) 
                || !isset($post['id']) 
                || !is_array($post)
            ) {
                $this->error('没有修改的数据！');
                return false;
            }
            
            if (empty($post['password'])) {
                $this->error('新密码不能为空！');
            }
            if (empty($post['password_confirm'])) {
                $this->error('确认密码不能为空！');
            }
            
            if ($post['password'] != $post['password_confirm']) {
                $this->error('两次密码不一致！');
            }
            
            $id = $post['id'];
            $password = $post['password'];
        
            $rs = UserFacade::changePassword($id, $password);
            if ($rs === false) {
                $this->error('修改密码失败！');
            }
            
            $this->success("修改密码成功！");
        } else {
            $id = $this->request->param('id');
            $data = UserModel::where([
                    "id" => $id,
                ])
                ->find();
            if (empty($data)) {
                $this->error('该信息不存在！');
            }
            
            $this->assign("data", $data);
            
            return $this->fetch();
        }
    }

}
