<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/4
 * Time: 23:34
 *
 * 前台页面 相关功能页面 的调度
 */
class ManageController extends Controller{

    /**
     *前台页面展示动作，展示之前需要先获取前台所需要加载的数据-->文章标签
     */
    public function indexAction(){
        $m_cag = Factory::M('CategoryModel');
        $m_cag->getAllCag();
        $m_com = Factory::M('CommentModel');
        $show_coms = 7;          //前台需要展示的评论数
        $m_com->getPartComs($show_coms);
        require CURRENT_VIEW_PATH.'frontManage.html';
    }

}