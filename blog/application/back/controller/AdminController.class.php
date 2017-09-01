<?php

/**
 * 后台管理员相关操作(登录，退出，找回密码，管理员增删改查，权限控制）控制器类
 */
class AdminController extends PlatformController {
	/**
	 * 登录表单动作
	 */
	public function loginAction() {
		//载入当前的视图层模板
		require CURRENT_VIEW_PATH .'administratorLogin.html';
	}
	/*
	 * 退出登录
	 *
	 * */
	public function signOutAction(){
	    unset($_SESSION['admin']);
	    $this->_jump('index.php?&p=back&c=Admin&a=login');
    }

	/**
	 * 验证管理员是否合法
	 */
	public function checkAction() {

	    //保存用户名和密码到cookie
        setcookie("username",$_POST['username']);
        setcookie("password",$_POST['password']);

	    //先验证验证码
        $t_captcha = new Captcha();
        if(!$t_captcha->checkCaptcha($_POST['captcha'])){
            //验证码错误
          //  @session_start();
            $this->_jump('index.php?p=back&c=Admin&a=login','验证码错误',3);
        }
		// 获得表单数据
		$admin_name = $_POST['username'];
		$admin_pass = $_POST['password'];

		//从数据库中验证管理员信息是否存在合法  操作数据表
        //工厂方法实例化模型类的单例对象，即每一个表（模型类）只对应一个操作模型（对象）
		$m_admin = Factory::M('AdminModel');
		if ($admin_info = $m_admin->check($admin_name, $admin_pass)) {
			//验证通过，合法  跳转到后台首页
            $_SESSION['admin'] = $admin_info;      //设置session防止未经登录的用户直接访问后台首页,并且获取管理员相关信息
            $this->_jump('index.php?p=back&c=Manage&a=index');
		} else {
			// 非法   跳转到登录页面
			$this->_jump('index.php?p=back&c=Admin&a=login','管理员信息有误');
		}
	}

	/*
	 * 利用Captcha工具生成验证码
	 *
	 */
    public function captchaAction(){
      //  @session_start();
        $captcha = new Captcha();
        $_SESSION['captcha_code'] = $captcha->getCode();
        $captcha->generate();
    }



}


















