<?php

namespace app\admin\controller;

use app\luser\model\Access as AccessModel;

/**
 * token普通授权
 *
 * @create 2020-8-23
 * @author deatil
 */
class LuserAccess extends LuserBase
{
    /**
     * 日志首页
     *
     * @create 2020-8-23
     * @author deatil
     */
    public function index()
    {
        if ($this->request->isAjax()) {
            $limit = $this->request->param('limit/d', 20);
            $page = $this->request->param('page/d', 1);
            
            $map = $this->buildparams();
            
            $data = AccessModel::field('*')
                ->withJoin(['user'])
                ->where($map)
                ->page($page, $limit)
                ->order('add_time DESC, user_id ASC')
                ->select()
                ->visible([
                    'user' => [
                        'username',
                        'nickname',
                    ]
                ])
                ->toArray();
            
            $total = AccessModel::where($map)->count();
            
            $result = [
                "code" => 0, 
                "count" => $total, 
                "data" => $data,
            ];
            
            return $this->json($result);
        } else {
            return $this->fetch();
        }
    }
    
    /**
     * 详情
     *
     * @create 2020-8-23
     * @author deatil
     */
    public function detail()
    {
        if (!$this->request->isGet()) {
            $this->error('访问错误！');
        }
        
        $id = $this->request->param('id');
        if (empty($id)) {
            $this->error('信息ID错误！');
        }
        
        $data = AccessModel::where([
                "id" => $id,
            ])
            ->find();
        if (empty($data)) {
            $this->error('信息不存在！');
        }
        
        $this->assign("data", $data);
        return $this->fetch();
    }
    
    /**
     * 授权登出
     *
     * @create 2020-8-23
     * @author deatil
     */
    public function logout()
    {
        if (!$this->request->isPost()) {
            $this->error('请求错误！');
        }
        
        $id = $this->request->param('id');
        if (empty($id)) {
            $this->error('信息ID错误！');
        }
        
        $data = AccessModel::where([
                "id" => $id,
            ])
            ->find();
        if (empty($data)) {
            $this->error('信息不存在！');
        }
        
        $status = AccessModel::where([
            'id' => $id,
        ])->update([
            'is_logout' => 1,
            'logout_time' => time(),
            'logout_ip' => request()->ip(),
        ]);
        if ($status === false) {
            return $this->error('登出失败！');
        }
        
        return $this->success('登出成功！');
    }
    
    /**
     * 删除一个月前的操作日志
     *
     * @create 2020-8-23
     * @author deatil
     */
    public function clear()
    {
        if (!$this->request->isPost()) {
            $this->error('请求错误！');
        }
        
        $status = AccessModel::where([
            ['is_logout', '=', 1],
            ['expire_time', '>= time', time()],
            ['add_time', '<= time', time() - (86400 * 30)],
        ])->delete();
        if ($status === false) {
            $this->error("删除记录失败！");
        }
        
        $this->success("删除记录成功！");
    }
}
