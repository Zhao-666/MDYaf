<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/20
 * Time: 20:56
 */

/**
 * @name IpModel
 * @desc IP地址归属地查询功能
 * @author pangee
 */
class IpModel
{
    public $errno = 0;
    public $errmsg = "";

    public function get($ip)
    {
        $rep = ThirdParty_Ip::find($ip);
        return $rep;
    }

}
