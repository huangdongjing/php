<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:13
 * 用于不需要进行登录验证的动作名控制
 */
class PlatformController extends Controller{
    public  function __construct()
    {
        parent::__construct();
        $this->checkLogin();
    }
    protected function checkLogin(){
        //验证是否具有登录标志
        new SessionDB();   //控制器一初始化就开启session

        //列出不需要登录验证的动作列表
        $without_check = array(
            'Admin' => array('login','check','captcha'),
            //控制器名 =>  当前控制器不需要验证的动作名列表数组
        );
        if(isset($without_check[CONTROLLER]) && in_array(ACTION,$without_check[CONTROLLER])){
            return;
        }
        if(!isset($_SESSION['admin'])){
            $this->_jump('index.php?p=back&c=Admin&a=login','你还没有登录，请先登录！',3);
        }
    }

}