<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/5
 * Time: 0:12
 *
 * 前台文章相关动作控制器
 */
class ArticlesController extends Controller{

    /**
     *前台页面获取所有文章
     */
    public function getAllArtsAction(){
        //使用page工具类，只需要知道分页容量和总记录条数即可
        $pageSize = 2;
        $m_art = Factory::M('ArticlesModel');
        $m_art->getAllArts($pageSize);

    }

    /**
     *前台页面获取文章id展示指定id，为用户设置cookie，记录文章浏览量
     */

    public function showArtByIdAction($com_art_id=-1){
        if(isset($_GET['art_id'])){
            $art_id =$_GET['art_id'] ;
        }
        if($com_art_id != -1){
            $art_id = $com_art_id;
        }
        $m_art = Factory::M('ArticlesModel');
        $m_art->showArtById($art_id);
        require CURRENT_VIEW_PATH.'showArtById.html';
    }

    /**
     *前台页面之评论指定id文章
     */


    public function insert_comAction(){
        $art_id = $_POST['com_art_id'];
        $comment_uname = $_POST['com_uname'];
        $comment_content = $_POST['com_content'];
        $m_com = Factory::M('CommentModel');
        $m_com->insertComment($art_id,$comment_uname,$comment_content);
        $this->showArtByIdAction($art_id);
    }


    /**
     *前台页面之进行文章关键字模糊搜索
     */


    public function art_searchAction(){
        $art_key = $_GET['art_key'];
        $pageSize = 10;        //每页最多展示的搜索记录条数
        $m_com = Factory::M('ArticlesModel');
        $m_com->searchKeyArticles($art_key,$pageSize);

    }


    /**
     * 前台页面之根据分类id读取文章列表
     */


    public function getCagArsAction(){
        $cag_id = $_GET['cag_id'];
        $pageSize = 10;
        $m_cag = Factory::M('CategoryModel');
        $m_cag->cagArtShow($cag_id,$pageSize);
    }


}