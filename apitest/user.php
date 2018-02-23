<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/23
 * Time: 11:04
 */
require_once __DIR__ . '/../vendor/autoload.php';

use \Curl\Curl;

$host = "http://localhost";
$curl = new Curl();
$uname = 'apitest_uname_' . rand();
$pwd = 'apitest_pwd_' . rand();

/**
 * 注册
 */
$curl->post(
    $host . '/user/register',
    ['uname' => $uname, 'pwd' => $pwd]
);
if ($curl->error) {
    die('Error:' . $curl->error_code . ':' . $curl->error_message);
} else {
    $rep = json_decode($curl->response, true);
    if ($rep['errno'] !== 0) {
        die('Error: Register Error');
    }
    echo 'Register success. New user：' . $uname . "\n";
}


/**
 * 登陆
 */
$curl->post(
    $host . '/user/login?submit=1',
    ['uname' => $uname, 'pwd' => $pwd]
);
if ($curl->error) {
    die('Error:' . $curl->error_code . ':' . $curl->error_message);
} else {
    $rep = json_decode($curl->response, true);
    if ($rep['errno'] !== 0) {
        die('Error: Login Error');
    }
    echo 'Login success. New user：' . $uname . "\n";
}

echo 'check done.' . "\n";