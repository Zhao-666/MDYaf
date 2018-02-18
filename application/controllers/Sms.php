<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/18
 * Time: 13:23
 */

class SmsController extends Yaf_Controller_Abstract
{
    public function indexAciton()
    {

    }

    public function sendAction()
    {
        $submit = $this->getRequest()->getQuery("submit", "0");
        if ($submit != "1") {
            echo json_encode(array("errno" => -4001, "errmsg" => "请通过正确渠道提交"));
            return FALSE;
        }

        // 获取参数
        $uid = $this->getRequest()->getPost("uid", false);
        if (!$uid ) {
            echo json_encode(array("errno" => -4002, "errmsg" => "用户ID、邮件标题、邮件内容均不能为空。"));
            return FALSE;
        }

        // 调用Model, 发邮件
        $model = new SmsModel();
        if ($model->send(intval($uid))) {
            echo json_encode(array(
                "errno" => 0,
                "errmsg" => "",
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