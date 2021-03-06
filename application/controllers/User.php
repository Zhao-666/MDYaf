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
        echo phpinfo();
    }

    public function loginAction()
    {
        $submit = Common_Request::getRequest('submit', '0');
        if ($submit != "1") {
            echo Common_Request::response(-1001, "请通过正确渠道提交");
            return FALSE;
        }

        // 获取参数
        $uname = Common_Request::postRequest("uname", false);
        $pwd = Common_Request::postRequest("pwd", false);
        if (!$uname || !$pwd) {
            echo Common_Request::response(-1002, "用户名与密码必须传递");
            return FALSE;
        }

        // 调用Model，做登录验证
        $model = new UserModel();
        $uid = $model->login(trim($uname), trim($pwd));
        if ($uid) {
            // 种Session
            session_start();
            $_SESSION['user_token'] = md5("salt" . $_SERVER['REQUEST_TIME'] . $uid);
            $_SESSION['user_token_time'] = $_SERVER['REQUEST_TIME'];
            $_SESSION['user_id'] = $uid;
            echo Common_Request::response(0, '', ['name' => $uname]);
        } else {
            echo Common_Request::response($model->errno, $model->errmsg);
        }
        return FALSE;
    }

    public function registerAction()
    {
        // 获取参数
        $uname = $this->getRequest()->getPost("uname", false);
        $pwd = $this->getRequest()->getPost("pwd", false);
        if (!$uname || !$pwd) {
            echo json_encode(Err_Map::get(1002));
            return FALSE;
        }

        // 调用Model，做登录验证
        $model = new UserModel();
        if ($model->register(trim($uname), trim($pwd))) {
            echo Common_Request::response(0, '', ['name' => $uname]);
        } else {
            echo json_encode(array(
                "errno" => $model->errno,
                "errmsg" => $model->errmsg,
            ));
        }
        return FALSE;
    }
}