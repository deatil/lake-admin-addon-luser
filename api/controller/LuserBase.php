<?php

declare (strict_types = 1);

namespace app\api\controller;

use think\App;

use Lake\Module\Traits\Json as JsonTrait;

/**
 * 控制器基础类
 */
abstract class LuserBase
{
    use JsonTrait;
    
    /**
     * Request实例
     * @var \think\Request
     */
    protected $request;

    /**
     * 应用实例
     * @var \think\App
     */
    protected $app;

    /**
     * 控制器中间件
     * @var array
     */
    protected $middleware = [
        'app\\luser\\middleware\\Api',
    ];

    /**
     * 构造方法
     * @access public
     * @param  App $app 应用对象
     */
    public function __construct(App $app)
    {
        $this->app = $app;
        $this->request = $this->app->request;

        // 控制器初始化
        $this->initialize();
    }

    // 初始化
    protected function initialize()
    {
        
    }
    
    /**
     * 空操作
     *
     * @create 2020-8-23
     * @author deatil
     */
    public function _empty()
    {
        $this->errorJson('该页面不存在！', 999);
    }

}
