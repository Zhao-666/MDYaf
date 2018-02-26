<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/26
 * Time: 22:53
 */

class Err_Map
{
    private static $ERRMAP = [
        1001 => '请通过正确渠道提交',
        1002 => '用户名与密码必须传递',
        1003 => '用户查找失败',
        1004 => '密码错误',
        1005 => '用户名已存在',
        1006 => '密码太短，请设置至少8位的密码'
    ];

    public static function get($code)
    {
        if (isset(self::$ERRMAP[$code])) {
            return ['errno' => (0 - $code),
                'errmsg' => self::$ERRMAP[$code]];
        }
        return ['errno' => (0 - $code),
            'errmsg' => 'undefine this error number'];
    }
}