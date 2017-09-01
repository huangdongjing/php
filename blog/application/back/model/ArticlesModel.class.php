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
     *业务逻辑之插入文章，涉及到对三张表的操作  有多条sql语句，并且彼此关联 因此要用事物操作
     * */
    public function insertArticle($art_title,$art_cag,$art_content){
        //先数据校验,貌似没什么可校验的

        $art_title_esc = $this->_dao->escapeString($art_title);
        $art_author = $_SESSION['admin']['admin_name'];
        //对文章表进行入库操作
        $this->_dao->query("start transaction;");

        $sql="insert into yy_article(article_title,article_content,article_createtime,article_lastmodifidtime,article_author)
values($art_title_esc,'$art_content',unix_timestamp(),unix_timestamp(),'$art_author')";
        $this->_dao->query($sql);

        $art_id = mysql_insert_id();
        //对类别表的文章数量进行更改操作和对文章-类别表进行入库操作
        for($i=0;$art_cag[$i]!=null;$i++){
            $sql1 = "select * from yy_article_category where category_name = '$art_cag[$i]'";
            $cag_id = $this->_dao->getOne($sql1);
            $sql2 = "update yy_article_category set article_count = article_count+1 where category_id = '$cag_id'";
            $this->_dao->query($sql2);
            $sql3 = "insert into yy_ar_ca(article_id,category_id) values('$art_id','$cag_id')";
            $this->_dao->query($sql3);
        }
        $this->_dao->query("commit;");
        $this->_dao->query("rollback;");
        return;
    }


    /*
    *业务逻辑之删除文章
    * */
    public function deleteArticle($art_id){

        $this->_dao->query("start transaction;");

        $sql1 = "update yy_article_category set article_count = article_count-1 where category_id in(select category_id from yy_ar_ca where article_id = '$art_id')";

        $this->_dao->query($sql1);

        //删除文章之前呢，要对所属类别的文章数量减一，要不然后续就不能操作了，因为ar_ca中的数据已经被清除了

        $sql="delete from yy_article where article_id = '$art_id'";
        $this->_dao->query($sql);

        $this->_dao->query("commit;");
        $this->_dao->query("rollback;");
        return;
    }

    /*
   *业务逻辑之编辑文章，获取文章相关信息在页面上显示以便编辑
   * */
    public function editArticle($art_id){

        $sql="select * from yy_article where article_id = '$art_id'";
        $_SESSION['edit_art'] = $this->_dao->getRow($sql);
        setcookie('edit_art_id',$_SESSION['edit_art']['article_id'],time()+1);
        setcookie('edit_art_title',$_SESSION['edit_art']['article_title'],time()+1);
        setcookie('edit_art_content',$_SESSION['edit_art']['article_content'],time()+1);
        return;
    }


    /*
        *业务逻辑之更新文章  同样涉及对三张表的更改
        * */
    public function updateArticle($art_id,$art_title,$art_cag,$art_content){

        $art_title_esc = $this->_dao->escapeString($art_title);
       // $art_author = $_SESSION['admin']['admin_name'];   用于判断是否是原作者


        $this->_dao->query("start transaction;");
        //因为文章分类是重新进行填充的，所以要先更改对应$art_id之前的类别文章数量,减一
        $sql = "update yy_article_category set article_count = article_count - 1 where category_id in (select category_id from yy_ar_ca 
       where article_id = '$art_id')";
        $this->_dao->query($sql);

        //再把yy_ar_ac中id为$art_id的文章全部删除，再重新插入，保证同步更改
        $sql = "delete from yy_ar_ca where article_id = '$art_id'";
        $this->_dao->query($sql);


        //同步更新三张表的内容
        //文章表
        $sql="update yy_article set article_title = $art_title_esc,article_content='$art_content',article_lastmodifidtime=unix_timestamp() 
        where article_id = '$art_id'" ;
        $this->_dao->query($sql);

        //分类表与文章分类表
        for($i=0;$art_cag[$i]!=null;$i++){
            $sql1 = "select * from yy_article_category where category_name = '$art_cag[$i]'";
            $cag_id = $this->_dao->getOne($sql1);
            $sql2 = "update yy_ar_ca set category_id = '$cag_id' where article_id = '$art_id'";
            $this->_dao->query($sql2);
            $sql3 = "insert into yy_ar_ca(article_id,category_id) values('$art_id','$cag_id')";
            $this->_dao->query($sql3);
        }
        $this->_dao->query("commit;");
        $this->_dao->query("rollback;");
        return;
    }


    /*
     *业务逻辑之后台文章列表展示
     * */
    public function showArticle($curPage,$pageSize){
        $sql1 = "select count(*) from yy_article";
        $totalRec = $this->_dao->getOne($sql1);

        if($totalRec == null || $totalRec == 0){
            $_SESSION['curPage'] = 1;
            $_SESSION['totalPag'] = 1;
            $_SESSION['totalRec'] = 0;
            $_SESSION['curp_arts'] = null;
            return;
        }
        $totalPag = $totalRec%$pageSize == 0 ? intval($totalRec/$pageSize) : intval($totalRec/$pageSize+1);  //计算总页数
        $pageSizes = $pageSize;  //记录一页总条数，防止超过总页数时使用

        //当前页大于总页数时
        if($curPage >= $totalPag){
            $curPage = $totalPag;
            $pageSize = $totalRec - ($totalPag-1)*$pageSizes;
        }

        //将总页数、总条数、当前页存入session，方便页面上使用
        $_SESSION['curPage'] = $curPage;
        $_SESSION['totalPag'] = $totalPag;
        $_SESSION['totalRec'] = $totalRec;

        $sql2 = "select * from yy_article limit ".($curPage-1)*$pageSizes.",".$pageSize;   //获取第curpage的数据
        $result = $this->_dao->getAll($sql2);
        $_SESSION['curp_arts'] = $result;
        return;
    }

}