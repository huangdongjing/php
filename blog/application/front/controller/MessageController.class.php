<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/5
 * Time: 0:13
 *
 * 前台留言相关功能动作
 */
class MessageController extends Controller{
    /**
     * 加载留言表单动作
     */
    public function loadMsgFormAction(){
        require CURRENT_VIEW_PATH.'leaveMessage.html';
    }


    /**
     * 对留言表单进行处理，插入操作
     */
    public function insert_msgAction(){
       $msg_uname = $_POST['msg_name'];
       $msg_content = $_POST['msg_content'];
       $m_msg = Factory::M('MessageModel');
       $m_msg->insertMsg($msg_uname,$msg_content);
       // require CURRENT_VIEW_PATH.'leaveMessage.html';
        $this->_jump('index.php?p=front&c=Articles&a=getAllArts');
    }

}