<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/20
 * Time: 19:50
 * 文章模型层，负责文章相关操作的业务逻辑处理
 */
class ArticlesModel extends Model{

    /*
     *业务逻辑之前台文章列表展示
     * */
    public function getAllArts($pageSize){
        $sql = "select count(*) from yy_article";
        $totalRec = $this->_dao->getOne($sql);
        $page = new Page($totalRec,$pageSize);
        $sql = '(select * from yy_article '.$page->limit.') order by article_id desc';
        $res = $this->_dao->getAll($sql);
        foreach ($res as $eachRow){
            echo "<div id='art_container'>";

            echo "<br><div id='article_list_view'>" ;
            printf("<div id='article_title'><h3><span class='article_title'><a href='javascript:loadArtById({$eachRow['article_id']},2);' id='a_title'>%s</a></span></h3></div>",$eachRow['article_title']);

             printf("<div id='article_description'>%s</div><br>",mb_substr($eachRow['article_content'],0,200,'utf-8'));

             echo "<div id='article_manage'>";

             printf("<span>%s</span> ",date('Y-m-d H:i',$eachRow['article_lastmodifidtime']));

             printf("<span title='阅读次数'><a href='javascript:loadArtById({$eachRow['article_id']},0);' title='浏览次数'>浏览</a>(%s)</span> ",$eachRow['article_view_count']);

              printf("<span title='评论次数'><a href='javascript:loadArtById({$eachRow['article_id']},1);' title='评论次数'>评论</a>(%s)</span> ",$eachRow['article_comment_count']);
           // loadArtById({$eachRow['article_id']})
                 echo "</div><br/>";
             echo "</div><br>";

             echo "</div>";
        }
        $pageManage = $page->fpage();
        echo "<br><br><br><div id='page'>".$pageManage."</div><br><br><br>";
    }




    /*
     *业务逻辑之前台点击某篇文章获取详细信息动作模型
     * */
    public function showArtById($art_id){
        if(!isset($_COOKIE['art_id'.$art_id])){
            setcookie('art_id'.$art_id,$art_id,time()+3600*24);
            $sql = "update yy_article set article_view_count=article_view_count+1 where article_id = '$art_id'";
            $this->_dao->query($sql);
        }

        //获取文章信息
        $sql = "select * from yy_article where article_id= '$art_id'";
        $_SESSION['cag_art_single'] = $this->_dao->getRow($sql);
        $sql = "select * from yy_article_comment where article_id = '$art_id'";
        $_SESSION['single_art_comments'] = $this->_dao->getAll($sql);

        //获取分类信息
        $sql = "select category_name from yy_article_category where category_id in(select category_id from yy_ar_ca where article_id = '$art_id')";
        $_SESSION['single_art_cag'] = $this->_dao->getAll($sql);

        return;
    }


    /**
     * 根据文章关键字对数据库文章进行检索
     */

    public function searchKeyArticles($art_key,$pageSize){
        $sql = "select * from yy_article where article_title like '%$art_key%' or article_content like '%$art_key%'group by article_title";
        $res = $this->_dao->getAll($sql);
        if($res==null){
            echo "没有找到符合条件的搜索结果！";
            return;
        }
        $totalSearchRec = count($res);
        $page = new Page($totalSearchRec,$pageSize);
        foreach ($res as $eachRow){
            echo "<div id='art_container'>";

            echo "<br><div id='article_list_view'>" ;
            printf("<div id='article_title'><h3><span class='article_title'><a href='javascript:loadArtById({$eachRow['article_id']},2);' id='a_title'>%s</a></span></h3></div>",$eachRow['article_title']);

            printf("<div id='article_description'>%s</div><br>",mb_substr($eachRow['article_content'],0,200,'utf-8'));

            echo "<div id='article_manage'>";

            printf("<span>%s</span> ",date('Y-m-d H:i',$eachRow['article_lastmodifidtime']));

            printf("<span title='阅读次数'><a href='javascript:loadArtById({$eachRow['article_id']},0);' title='浏览次数'>浏览</a>(%s)</span> ",$eachRow['article_view_count']);

            printf("<span title='评论次数'><a href='javascript:loadArtById({$eachRow['article_id']},1);' title='评论次数'>评论</a>(%s)</span> ",$eachRow['article_comment_count']);
            // loadArtById({$eachRow['article_id']})
            echo "</div><br/>";
            echo "</div><br>";

            echo "</div>";
        }
        $pageManage = $page->fpage();
        echo "<br><br><br><div id='page'>".$pageManage."</div><br><br><br>";
    }






}