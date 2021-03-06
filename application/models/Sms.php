<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/18
 * Time: 13:24
 */

class SmsModel
{
    public $errno = 0;
    public $errmsg = "";
    private $_db;

    public function __construct()
    {
        $this->_db = new PDO("mysql:host=127.0.0.1;dbname=imooc;", "root", "root");
    }

    public function send($uid)
    {
        $query = $this->_db->prepare("select `mobile` from `user` where `id`= ? ");
        $query->execute(array(intval($uid)));
        $ret = $query->fetchAll();
        if (!$ret || count($ret) != 1) {
            $this->errno = -4003;
            $this->errmsg = "用户手机号信息查找失败";
            return false;
        }
        $userMobile = $ret[0]['mobile'];
        if (!$userMobile || !is_numeric($userMobile) || strlen($userMobile) != 11) {
            $this->errno = -4004;
            $this->errmsg = "用户手机号信息不符合标准，手机号为：" . (!$userMobile ? "空" : $userMobile);
            return false;
        }

        $smsUid = "phpdemo147";
        $smsPwd = "phpdemo147";
        $sms = new ThirdParty_Sms($smsUid, $smsPwd);

        $contentParam = array('code' => rand(1000, 9999));
        $template = '100006';
        $result = $sms->send($userMobile, $contentParam, $template);
        if ($result['stat'] == '100') {
            /**
             * 成功则记录，用于日后对账
             */
            $query = $this->_db->prepare("insert into `sms_record` (`uid`,`contents`,`template`) VALUES ( ?, ?, ? )");
            $ret = $query->execute(array($uid, json_encode($contentParam), $template));
            if (!$ret) {
                /**
                 * TODO 应该返回true还是false，有待商榷
                 */
                $this->errno = -4006;
                $this->errmsg = '消息发送成功，但发送记录失败。';
                return false;
            }
            return true;
        } else {
            $this->errno = -4005;
            $this->errmsg = '发送失败:' . $result['stat'] . '(' . $result['message'] . ')';
            return false;
        }
    }
}