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
     * 前台插入留言动作
     */


    public function insertMsg($msg_uname,$msg_content){
        $ip = new GetIp();
        $msg_uname = $this->_dao->escapeString($msg_uname);
        $msg_content = $this->_dao->escapeString($msg_content);
        $message_ip = $ip->getClientIp();
        $sql = "insert into yy_message(message_ip,message_content,message_createtime,message_author)
values(inet_aton('$message_ip'),$msg_content,unix_timestamp(),$msg_uname)";
        $this->_dao->query($sql);
        return;
    }








}