<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/25
 * Time: 22:28
 */

class Db_Base
{
    public static $errno = 0;
    public static $errmsg = "";
    public static $db = null;

    public static function getDb()
    {
        if (self::$db == null) {
            self::$db = new PDO("mysql:host=127.0.0.1;dbname=imooc;", "root", "root");
        }
        return self::$db;
    }

    public function errno()
    {
        return self::$errno;
    }

    public function errmsg()
    {
        return self::$errmsg;
    }
}