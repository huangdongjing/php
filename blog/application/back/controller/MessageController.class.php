<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 13:43
 *
 * 留言相关操作控制器
 */
class MessageController extends PlatformController{



    /*
     * 加载留言管理界面 动作
     *
     * */

    public function mes_magAction(){
        //首先从数据库中取15条记录，存于session中，然后在客户端加载数据
        $pageSize = 10;  //每页展示的留言数
        if(!isset($_GET['curPage'])){
            $curPage = 1;
        }else $curPage = $_GET['curPage'];
        $m_msg = Factory::M('MessageModel');
        $m_msg->getAllMsg($curPage,$pageSize);
        require CURRENT_VIEW_PATH.'adminMsgMag.html';
    }

    /*
    * 添加留言动作   -->后台不用，前台完成该功能
    *
    * */
    public function insertAction(){

    }

    /*
   * 删除留言动作
   *
   * */
    public function delete_msgAction(){
        $msg_id = $_GET['msg_id'];
        $m_msg = Factory::M('MessageModel');
        $m_msg->delMsgById($msg_id);
        $this->_jump('index.php?p=back&c=Message&a=mes_mag');
    }
}