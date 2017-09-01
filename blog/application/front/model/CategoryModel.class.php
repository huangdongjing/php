<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 14:15
 *
 * 文章分类业务逻辑相关操作
 */
class CategoryModel extends Model{

    /**
     * 前台之获取所有文章分类存于session用于展示
     */

    public function getAllCag(){
        $sql = "select * from yy_article_category";
        $_SESSION['allCag'] = $this->_dao->getAll($sql);
        return;
    }




    /*
     * 前台之文章分类展示
     * */

    public function cagArtShow($cag_id,$pageSize){
        $sql = '(select * from yy_article where article_id in(select article_id from yy_ar_ca where category_id = '.$cag_id.')) order by article_id desc';
        $res = $this->_dao->getAll($sql);
        if($res==null){
            echo "sorry,暂无该标签的文章！";
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