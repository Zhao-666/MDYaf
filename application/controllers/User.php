<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/9
 * Time: 21:34
 */

class UserController extends Yaf_Controller_Abstract
{
    public function indexAction()
    {

    }

    public function registerAction()
    {
        // 获取参数
        $uname = $this->getRequest()->getPost("uname", false);
        $pwd = $this->getRequest()->getPost("pwd", false);
        if (!$uname || !$pwd) {
            echo json_encode(array("errno" => -1002, "errmsg" => "用户名与密码必须传递"));
            return FALSE;
        }

        // 调用Model，做登录验证
        $model = new UserModel();
        if ($model->register(trim($uname), trim($pwd))) {
            echo json_encode(array(
                "errno" => 0,
                "errmsg" => "",
                "data" => array("name" => $uname)
            ));
        } else {
            echo json_encode(array(
                "errno" => $model->errno,
                "errmsg" => $model->errmsg,
            ));
        }
        return FALSE;
    }
}