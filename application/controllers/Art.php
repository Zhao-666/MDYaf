<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/13
 * Time: 15:48
 */

class ArtController extends Yaf_Controller_Abstract
{
    public function indexAction()
    {
        return $this->listAction();
    }

    public function addAction($artId = 0)
    {
        if (!$this->isAdmin()) {
            echo json_encode(array("errno" => -2000, "errmsg" => "需要管理员权限才可以操作"));
            return FALSE;
        }
        $submit = $this->getRequest()->getQuery("submit", "0");
        if ($submit != "1") {
            echo json_encode(array("errno" => -2001, "errmsg" => "请通过正确渠道提交"));
            return FALSE;
        }

        // 获取参数
        $title = $this->getRequest()->getPost("title", false);
        $contents = $this->getRequest()->getPost("contents", false);
        $author = $this->getRequest()->getPost("author", false);
        $cate = $this->getRequest()->getPost("cate", false);

        if (!$title || !$contents || !$author || !$cate) {
            echo json_encode(array("errno" => -2002, "errmsg" => "标题、内容、作者、分类信息为空，不能为空"));
            return FALSE;
        }

        // 调用Model，做登录验证
        $model = new ArtModel();
        if ($lastId = $model->add(trim($title), trim($contents), trim($author), trim($cate), $artId)) {
            echo json_encode(array(
                "errno" => 0,
                "errmsg" => "",
                "data" => array("lastId" => $lastId),
            ));
        } else {
            echo json_encode(array(
                "errno" => $model->errno,
                "errmsg" => $model->errmsg,
            ));
        }
        return TRUE;
    }

    public function editAction()
    {
        if (!$this->_isAdmin()) {
            echo json_encode(array("errno" => -2000, "errmsg" => "需要管理员权限才可以操作"));
            return FALSE;
        }

        $artId = $this->getRequest()->getQuery("artId", "0");
        if (is_numeric($artId) && $artId) {
            return $this->addAction($artId);
        } else {
            echo json_encode(array("errno" => -2003, "errmsg" => "缺少必要的文章ID参数"));
        }
        return TRUE;
    }

    public function listAction()
    {
        return true;
    }

    private function isAdmin()
    {
        return true;
    }
}