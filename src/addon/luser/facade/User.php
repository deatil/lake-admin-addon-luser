<?php

declare (strict_types = 1);

namespace app\luser\facade;

use think\Facade;

use app\luser\service\User as UserService;

/**
 * 用户
 *
 * @create 2020-8-21
 * @author deatil
 */
class User extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return UserService::class;
    }
}
