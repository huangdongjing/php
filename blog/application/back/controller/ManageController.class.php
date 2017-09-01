<?php
/*
 * 后台管理平台首页
 * 各个模块的展示调用
 */
class ManageController extends PlatformController{
    /*
     * 首页动作
     */
    public function indexAction(){

        if(isset($_SESSION['admin'])){
            require CURRENT_VIEW_PATH."adminManage.html";
        }
        else{
            $this->_jump('index.php?p=back&c=Admin&a=login','你还没有登录，请先登录',3);
        }
    }

    /*
     * 后台首页头部展示
     * */
    public function topAction(){
        require CURRENT_VIEW_PATH."adminTopFrame.html";
    }

    /*
   * 后台首页左部导航栏展示
   * */
    public function leftAction(){
        require CURRENT_VIEW_PATH."adminLeftFrame.html";
    }



    /*
   * 后台首页右部主体内容展示展示
   * */
    public function rightAction(){
        require CURRENT_VIEW_PATH."adminRightFrame.html";
    }

}