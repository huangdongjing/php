<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/6
 * Time: 11:24
 * session入库工具类   注意方法中前面注释的部分为之前的调试代码
 */
class SessionDB{
private $_dao;
public function __construct()
{
    //设置session处理器
    ini_set('session.save_handler','user');
    session_set_save_handler(
        array($this,'userSessionBegin'),  //此处需要注意函数与方法的不同之处，方法是对象所有的
        array($this,'userSessionEnd'),
        array($this,'userSessionRead'),
        array($this,'userSessionWrite'),
        array($this,'userSessionDelete'),
        array($this,'userSessionGc')
    );
    session_start();
}

    /*
 *
 * 开始函数
 * session开启时，最早执行的一个存储机制相关方法，用于初始化存储操作的相关资源
 *
 * 如 数据库连接
 *
 * */
    function userSessionBegin(){
       // echo "<br/>begin<br/>"；
//        $link = mysql_connect('localhost:3306','root','123');
//        mysql_query('set names utf8');
//        mysql_query('use test');
        //初始化dao
        $config = $GLOBALS['config']['db'];
        $this->_dao = MySQLDB::getInstance($config);//$dao , Database Access Object 数据库操作对象（dao层）

    }

    /*
     *
     * 结束函数
     * session机制关闭时，执行的方法，最后一个执行的存储相关操作，用于首尾工作
     *
     * 如 数据库连接
     *
     * */

    function userSessionEnd(){
      //  echo "<br/>end<br/>";
        return true;
    }
    /*
    * 读操作，时机：session机制开启过程中执行，
     * 工作： 从当前session数据区中读取数据
    */
    function userSessionRead($sess_id){
// 先初始化数据库服务器连接
      //  echo "<br/>read<br/>";
        $sql = "select session_content from yy_session where session_id='$sess_id'";
       return (string)$this->_dao->getOne($sql);


    }

    /*
    *   写操作 时机：脚本周期结束时，Php在整理收尾时
    *    工作：将当前脚本处理好的session数据，持久化到数据库中
    */
    function userSessionWrite($sess_id,$sess_content){
       // echo "<br/>write<br/>";

        $sql = "replace into yy_session values('$sess_id','$sess_content',unix_timestamp())";
        return $this->_dao->query($sql);
    }


    /*
    *   删除操作 时机：用户调用session_destroy() 时被调用
    *    工作：删除当前session的数据区
    */
    function userSessionDelete($sess_id){
      //  echo "<br/>delete<br/>";
        $sql = "delete from yy_session where session_id = '$sess_id'";
        return $this->_dao->query($sql);

    }


    /*
     * 垃圾回收操作
     * 执行时机：开启session机制时，有概率的执行
     * 工作：删除那些过期的session数据区
     *
     * */

    function userSessionGc($max_lifetime){     //垃圾回收
    //    echo "<br/>gc<br/>";
        $sql = "delete from yy_session where last_acessed_time < unix_timestamp()-$max_lifetime";
        return $this->_dao->query($sql);

    }




}