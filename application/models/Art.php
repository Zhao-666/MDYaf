<?php
/**
 * Created by PhpStorm.
 * User: Next
 * Date: 2018/2/13
 * Time: 15:59
 */

class ArtModel
{
    public $erron = 0;
    public $errmsg = "";
    private $_db;

    public function __construct()
    {
        $this->_db = new PDO("mysql:host=127.0.0.1;dbname=imooc;", "root", "root");
        /**
         * 不设置下面这行的话，PDO会在拼SQL时候，把int 0转成string 0
         */
        $this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    }

    public function add($title, $contents, $author, $cate, $artId = 0)
    {
        $isEdit = false;
        if ($artId != 0 && is_numeric($artId)) {
            $query = $this->_db->prepare("select count(*) from `art` where `id`= ? ");
            $query->execute(array($artId));
            $ret = $query->fetchAll();
            if (!$ret || count($ret) != 1) {
                $this->errno = -2004;
                $this->errmsg = "找不到你要编辑的文章！";
                return false;
            }
            $isEdit = true;
        } else {
            /**
             * 检查Cate是否存在
             * 如果是编辑文章，cate之前创建过，此处可不必再做校验
             */
            $query = $this->_db->prepare("select count(*) from `cate` where `id`= ? ");
            $query->execute(array($cate));
            $ret = $query->fetchAll();
            if (!$ret || $ret[0][0] == 0) {
                $this->errno = -2005;
                $this->errmsg = "找不到对应ID的分类信息，cate id:" . $cate . ", 请先创建该分类。";
                return false;
            }
        }

        /**
         * 插入或者更新文章内容
         */
        $data = array($title, $contents, $author, intval($cate));
        if (!$isEdit) {
            $query = $this->_db->prepare("insert into `art` (`title`,`contents`,`author`,`cate`) VALUES ( ?, ?, ?, ? )");
        } else {
            $query = $this->_db->prepare("update `art` set `title`=?, `contents`=?, `author`=?, `cate`=? where `id`= ?");
            $data[] = $artId;
        }
        $ret = $query->execute($data);
        if (!$ret) {
            $this->errno = -2006;
            $this->errmsg = "操作文章数据表失败, ErrInfo:" . end($query->errorInfo());
            return false;
        }
        /**
         * 返回文章最后的ID值
         */
        if (!$isEdit) {
            return intval($this->_db->lastInsertId());
        } else {
            return intval($artId);
        }
    }
}