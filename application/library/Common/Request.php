<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/23
 * Time: 12:29
 */

class Common_Request
{
    public static function request($key, $default = null, $type = null)
    {
        if ($type == 'get') {
            $result = isset($_GET[$key]) ? trim($_GET[$key]) : null;
        } elseif ($type == 'post') {
            $result = isset($_POST[$key]) ? trim($_POST[$key]) : null;
        } else {
            $result = isset($_REQUEST[$key]) ? trim($_REQUEST[$key]) : null;
        }

        if ($default != null && $result == null) {
            $result = $default;
        }
        return $result;
    }

    public static function getRequest($key, $default = null)
    {
        return self::request($key, $default, 'get');
    }

    public static function postRequest($key, $default = null)
    {
        return self::request($key, $default, 'post');
    }

    public static function response($errno = 0, $errmsg = "", $data = null)
    {
        $rep = array(
            'errno' => $errno,
            'errmsg' => $errmsg
        );
        if ($data != null) {
            $rep['data'] = $data;
        }
        return json_encode($rep);
    }
}