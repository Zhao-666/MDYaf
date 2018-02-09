<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/9
 * Time: 21:34
 */

class UserController extends Yaf_Controller_Abstract
{

    /**
     * 默认动作
     * Yaf支持直接把Yaf_Request_Abstract::getParam()得到的同名参数作为Action的形参
     * 对于如下的例子, 当访问http://yourhost/imooc/index/index/index/name/root 的时候, 你就会发现不同
     */
    public function regAction($name = "User Reg")
    {
        //1. fetch query
        $get = $this->getRequest()->getQuery("get", "default value");

        //2. fetch model
        $model = new SampleModel();

        var_dump($name);
        //3. assign
        $this->getView()->assign("content", $model->selectSample());
        $this->getView()->assign("name", $name);

        //4. render by Yaf, 如果这里返回FALSE, Yaf将不会调用自动视图引擎Render模板
        return false;
    }
}