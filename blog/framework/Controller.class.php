<?php

/**
 * 基础控制器
 */
class Controller {

	/**
	 * 构造方法
	 */
	public function __construct() {
		$this->_initContentType();
		$this->_initGmt();
	}


	/**
	 * 初始化Content-Type
	 */
	protected function _initContentType() {
		header("Content-Type: text/html; charset=utf-8");
	}



    /**
     * 初始化时区
     */
    protected function _initGmt() {
        date_default_timezone_set('Asia/Shanghai');
    }



	/*
	 * 封装页面跳转功能
	 */

	protected function _jump($url,$info=null,$wait=3){
	    //判断是立即跳转还是提示跳转
        if(is_null($info)){
            Header('location:'.$url);
        }
        else{
            Header("Refresh:$wait;url=$url");
            echo $info;
        }
        die;          //终止脚本
    }
}













