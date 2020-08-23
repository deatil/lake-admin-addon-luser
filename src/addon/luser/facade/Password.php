<?php

declare (strict_types = 1);

namespace app\luser\facade;

use think\Facade;

use app\luser\lib\Password as PasswordLib;

/**
 * 密码
 *
 * @create 2020-8-21
 * @author deatil
 */
class Password extends Facade
{
    /**
     * 获取当前Facade对应类名（或者已经绑定的容器对象标识）
     * @access protected
     * @return string
     */
    protected static function getFacadeClass()
    {
        return PasswordLib::class;
    }
}
