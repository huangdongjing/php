<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 13:50
 */
class PhotoController extends PlatformController{
    /*
     * 相册管理界面 动作
     * */
    public function phomagAction(){
        require CURRENT_VIEW_PATH . 'adminPhoMag.html';
    }


    /*
     * 添加照片 动作
     * */
    public function insertAction(){

    }


    /*
     * 删除照片 动作
     * */
    public function deleteAction(){

    }

}