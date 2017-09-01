<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 14:19
 *
 * 留言相关业务逻辑操作模型
 */
class MessageModel extends Model{

/**
 *
 * 获得所有留言
 */

public function getAllMsg($curPage,$pageSize){
    $sql="select count(*) from yy_message";
    $totalRec = $this->_dao->getOne($sql);
    if($totalRec == null || $totalRec == 0){
        $_SESSION['curPage'] = 1;
        $_SESSION['totalPag'] = 1;
        $_SESSION['totalRec'] = 0;
        $_SESSION['curp_msgs'] = null;
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
    $sql2 = "select message_id,message_content,message_createtime,message_author,inet_ntoa(message_ip)as msg_ip from yy_message limit ".($curPage-1)*$pageSizes.",".$pageSize;   //获取第curpage的数据
    $result = $this->_dao->getAll($sql2);
    $_SESSION['curp_msgs'] = $result;
    return;
}


/**
 * 删除指定Id留言
 */

public function delMsgById($msg_id){
    $sql="delete from yy_message where message_id = '$msg_id'";
    $this->_dao->query($sql);
    return;
}

}



