<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/20
 * Time: 18:51
 * 后台文章相关操作控制器   发表文章  文章管理  类别管理   评论管理
 */
class ArticlesController extends PlatformController{


    /*
     * 添加文章    的     表单html 动作
     * */
    public function art_addAction(){
        $m_cag = Factory::M('CategoryModel');
        $m_cag->getAllCag();
        require CURRENT_VIEW_PATH.'adminArticleAdd.html';

    }

    /*
             * 添加文章入库    的    动作  新增与修改
             * */
    public function insert_artAction(){
        // 先收集表单数据
        $art_title = $_POST['article_title'];
        $art_cag = $_POST['article_category'];
        $art_content = $_POST['content'];
        $art_cags = explode(',',$art_cag);
        //实例化模型层单例对象,业务逻辑提交给Model层处理

        //如果是要修改文章
        if($_POST['hid_id'] != null || $_POST['hid_id'] != ''){
            $art_id = $_POST['hid_id'];
            $m_art = Factory::M('ArticlesModel');
            $m_art->updateArticle($art_id,$art_title,$art_cags,$art_content);
        }
        //如果是新增文章
        else {
            $m_art = Factory::M('ArticlesModel');
            $m_art->insertArticle($art_title, $art_cags, $art_content);

        }

        //跳转到前台？？还是文章管理界面？
        $this->_jump('index.php?p=back&c=Articles&a=art_mag');
    }


    /*
   * 文章管理界面动作
   * */

    public function art_magAction(){
        //首先从数据库中取15条记录，存于session中，然后在客户端加载数据
        $pageSize = 15;
        if(!isset($_GET['curPage'])){
            $curPage = 1;
        }else $curPage = $_GET['curPage'];
        $m_art = Factory::M('ArticlesModel');
        $m_art->showArticle($curPage,$pageSize);
        require CURRENT_VIEW_PATH . 'adminArtMag.html';
    }



    /*
     * 删除文章    动作
     * */
    public function delete_artAction(){
        $article_id = $_GET['art_id'];
        $m_art = Factory::M('ArticlesModel');
        $m_art->deleteArticle($article_id);
        $this->_jump('index.php?p=back&c=Articles&a=art_mag');
    }

    /*
     * 编辑文章    动作
     * */
    public function edit_artAction(){
        $art_id = $_GET['art_id'];
        $m_art = Factory::M('ArticlesModel');
        $m_art->editArticle($art_id);
        $this->_jump('index.php?p=back&c=Articles&a=art_add');
   }



    /*
 * 类别管理界面动作
 * */

    public function cag_magAction(){
        /*
         * 实例化一个对象，获得所有的分类
         * */
        $m_cag = Factory::M('CategoryModel');
        $m_cag->getAllCag();
        require CURRENT_VIEW_PATH . 'adminCagMag.html';
    }

    /*
     * 添加文章类别入库    的    动作
     * */
    public function insert_cagAction(){
        // 先收集表单数据

        $category = $_POST['category'];
        //实例化模型层单例对象
        $m_cag = Factory::M('CategoryModel');

        //业务逻辑提交给Model层处理
        $m_cag->insert($category);
        $this->_jump('index.php?p=back&c=Articles&a=cag_mag');
    }

    /*
        * 删除文章类别    动作
        * */
    public function delete_cagAction(){
        $cag_id = $_GET['cag_id'];
        $m_cag = Factory::M('CategoryModel');
        $m_cag->delete($cag_id);
        $this->_jump('index.php?p=back&c=Articles&a=cag_mag');
    }

    /*
     * 更新文章 类别   动作
     * */
    public function edit_cagAction(){

        $pama = $_POST['cag_rename'];
        $arr = explode(",",$pama);
        $cag_rename = $arr[1] ;
        $cag_id = $arr[0];
        //die('$cag_id='.$cag_id);

        $m_cag = Factory::M('CategoryModel');
        $m_cag->edit($cag_id,$cag_rename);
        $this->_jump('index.php?p=back&c=Articles&a=cag_mag');
    }

    /*
   * 展示每种类别的所有文章
   * */
    public function cag_art_showAction(){
        $cag_id = $_GET['cag_id'];
        $m_cag = Factory::M('CategoryModel');
        $m_cag->cagArtShow($cag_id);
       require CURRENT_VIEW_PATH.'adminCagArtShow.html';
    }


    /*
     * 展示指定id的文章
     * */
    public function cag_art_single_showAction($art_id = -1){
        if($art_id!=-1){
            $art_id1 = $art_id;
            $m_cag = Factory::M('CategoryModel');
            $m_cag->cagArtSingleShow($art_id1);
            require CURRENT_VIEW_PATH.'adminCagArtSingleShow.html';
            return;
        }

        $art_id1 = $_GET['art_id'];
        $m_cag = Factory::M('CategoryModel');
        $m_cag->cagArtSingleShow($art_id1);
        require CURRENT_VIEW_PATH.'adminCagArtSingleShow.html';
    }





    /*
 * 文章评论管理界面动作
 * */

    public function com_magAction(){
        //首先从数据库中取15条记录，存于session中，然后在客户端加载数据
        $pageSize = 15;
        if(!isset($_GET['curPage'])){
            $curPage = 1;
        }else $curPage = $_GET['curPage'];
        $m_com = Factory::M('CommentModel');
        $m_com->showComment($pageSize,$curPage);
        require CURRENT_VIEW_PATH . 'adminComMag.html';
    }

    /*
          * 删除文章评论   动作
          * */
    public function com_deleteAction(){
        $com_id = $_GET['com_id'];
        $m_com = Factory::M('CommentModel');
        $m_com->deleteComment($com_id);
        $this->_jump("index.php?p=back&c=Articles&a=com_mag");
    }


    /*
         * 添加文章评论   动作
         * */
    public function comment_artAction(){
        $art_id = $_POST['art_id'];
        $comment_uname = $_POST['comment_uname'];
        $comment_content = $_POST['comment_content'];
        $m_com = Factory::M('CommentModel');
        $m_com->insertComment($art_id,$comment_uname,$comment_content);
        $this->cag_art_single_showAction($art_id);
    }
}













