<?php

namespace app\luser\validate;

use think\Validate;

/**
 * 模型验证
 *
 * @create 2020-8-21
 * @author deatil
 */
class User extends Validate
{
    //定义验证规则
    protected $rule = [
        'username' => 'require|regex:/^[a-zA-Z][A-Za-z0-9\_]+$/',
        'nickname' => 'require|chsAlpha',
        'status' => 'in:0,1',
    ];
    
    //定义验证提示
    protected $message = [
        'username.require' => '字段名称不得为空',
        'username.regex' => '字段名称只能为字母、数字及下划线，并且仅能字母开头',
        'nickname.require' => '字段标题不得为空',
        'nickname.chsAlpha' => '字段标题只能为只能是汉字和字母',
        'status.in' => '字段状态格式错误',
    ];
}
