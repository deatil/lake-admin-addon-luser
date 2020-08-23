<?php

namespace app\admin\controller;

use app\luser\model\Log as LogModel;

/**
 * 日志
 *
 * @create 2020-8-23
 * @author deatil
 */
class LuserLog extends LuserBase
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
            
            $data = LogModel::field('*')
                ->withJoin(['user'])
                ->where($map)
                ->page($page, $limit)
                ->order('login_time DESC, user_id ASC')
                ->select()
                ->visible([
                    'user' => [
                        'username',
                        'nickname',
                    ]
                ])
                ->toArray();
            
            $total = LogModel::where($map)->count();
            
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
        
        $data = LogModel::where([
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
        
        $status = LogModel::where([
            ['login_time', '<= time', time() - (86400 * 30)]
        ])->delete();
        if ($status === false) {
            $this->error("删除日志失败！");
        }
        
        $this->success("删除日志成功！");
    }
}
