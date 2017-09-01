<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 14:17
 *
 * 文章评论业务逻辑相关操作
 */
class CommentModel extends Model{
/*
 * 插入对应文章的评论
 * */
public function insertComment($art_id,$comment_uname,$comment_content){
    $comment_uname_esc = $this->_dao->escapeString($comment_uname);
    $comment_content_esc = $this->_dao->escapeString($comment_content);
    $sql = "insert into yy_article_comment(article_id,comment_content,comment_uname,comment_time) values('$art_id',$comment_content_esc,$comment_uname_esc,unix_timestamp())";
    if($comment_uname_esc == null || $comment_uname_esc == ''){
        $sql = "insert into yy_article_comment(article_id,comment_content,comment_time)values('$art_id',$comment_content_esc,unix_timestamp())";
    }
    $sql1 = "update yy_article set article_comment_count = article_comment_count+1 where article_id = '$art_id'";
    $this->_dao->query("start transaction");
    $this->_dao->query($sql1);
    $this->_dao->query($sql);
    $this->_dao->query("commit");
    $this->_dao->query("rollback");
    return;
}

/*
* 分页展示评论
* */
public function showComment($pageSize,$curPage){

    $sql1 = "select count(*) from yy_article_comment";
    $totalRec = $this->_dao->getOne($sql1);

    if($totalRec == null || $totalRec == 0){
        $_SESSION['curPage'] = 1;
        $_SESSION['totalPag'] = 1;
        $_SESSION['totalRec'] = 0;
        $_SESSION['curp_arts'] = null;
        return;
    }
    $totalPag = $totalRec%$pageSize == 0 ? intval($totalRec/$pageSize) : intval($totalRec/$pageSize+1);  //计算总页数
    $pageSizes = $pageSize;  //记录一页总条数，防止超过总页数时使用

    //当前页大于总页数时
    if($curPage >= $totalPag){
        $curPage = $totalPag;
        $pageSize = $totalRec - ($totalPag-1)*$pageSizes;
    }

    //将总页数、总条数、当前页存入session，方便页面上使用
    $_SESSION['curPage'] = $curPage;
    $_SESSION['totalPag'] = $totalPag;
    $_SESSION['totalRec'] = $totalRec;

    //联合查询
    $sql2 = "select c.comment_id as com_id,a.article_id as art_id,a.article_title as art_title,c.comment_content as com_content,c.comment_uname as com_uname,c.comment_time as com_time 
from yy_article_comment as c left join yy_article as a on a.article_id = c.article_id limit ".($curPage-1)*$pageSizes.",".$pageSize;   //获取第curpage的数据;
    $result = $this->_dao->getAll($sql2);
    $_SESSION['curp_coms'] = $result;
    return;
}


    /*
    * 删除对应com_id的评论，涉及对两张表的操作
    * */
    public function deleteComment($com_id){
        $sql = "delete from yy_article_comment where comment_id = '$com_id'";
        $sql1 = "update yy_article set article_comment_count = article_comment_count-1 where article_id in
(select article_id from yy_article_comment where comment_id = '$com_id')";
        $this->_dao->query("start transaction");
        $this->_dao->query($sql1);
        $this->_dao->query($sql);
        $this->_dao->query("commit");
        $this->_dao->query("rollback");
        return;
    }

}
