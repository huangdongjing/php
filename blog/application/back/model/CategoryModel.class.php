<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 14:15
 *
 * 文章分类业务逻辑相关操作
 */
class CategoryModel extends Model{

    public function getAllCag(){
        $sql = "select * from yy_article_category";
        $_SESSION['allCag'] = $this->_dao->getAll($sql);
    }



    public function insert($category){
        $category_escap = $this->_dao->escapeString($category);
       // die("categoroname:".$category_escap);
        $sql1 = "select * from yy_article_category where category_name = $category_escap";
        //如果数据库中存在重复的类别，仅不进行操作
        if($this->_dao->getRow($sql1)){
            return;
        }
        $sql = "insert into yy_article_category(category_name,category_createtime) values($category_escap,unix_timestamp())";

        $result = $this->_dao->query($sql);
        return $result;
    }




    public function delete($cag_id){
        $sql = "delete from yy_article_category where category_id = '$cag_id'";
        $result = $this->_dao->query($sql);
        return $result;
    }




    public function edit($cag_id,$cag_rename){
        $cag_rename_esc = $this->_dao->escapeString($cag_rename);
        $sql = "update yy_article_category set category_name = $cag_rename_esc where category_id = '$cag_id'";
        //die($sql);
        $result = $this->_dao->query($sql);
        return $result;
    }


    /*
     * 文章分类展示
     * */

    public function cagArtShow($cag_id){
        $sql = "select * from yy_article where article_id in(select article_id from yy_ar_ca where category_id = '$cag_id')";
        $_SESSION['cag_art_list'] = $this->_dao->getAll($sql);
        return;
    }

    public function cagArtSingleShow($art_id){
        $sql = "select * from yy_article where article_id= '$art_id'";
        $_SESSION['cag_art_single'] = $this->_dao->getRow($sql);
        $sql = "select * from yy_article_comment where article_id = '$art_id'";
        $_SESSION['single_art_comments'] = $this->_dao->getAll($sql);

        return;
    }
}