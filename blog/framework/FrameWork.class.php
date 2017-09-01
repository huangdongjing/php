<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/8
 * Time: 19:35
 */
class FrameWork{
    /*
     * 入口
     * */
    public static function  run(){
        static::initPathConst();  //self等于static
        static::initConfig();
        static::initDispatchParam();
        static::initPlatfromPathConst();
        static::initSplAutoLoad();
        static::initDispatch();
    }

    /*
     * 声明路径常量
     * */

private static  function initPathConst(){
//目录基础常量的定义
        define('ROOT_PATH', getcwd(). '/');//getCWD()获得当前目录
        define('APPLICATION_PATH', ROOT_PATH . 'application/');
       // define('BACK_JS_PATH',ROOT_PATH.'web/back/js/');
        define('CONFIG_PATH',APPLICATION_PATH.'config/');
        define('FRAMEWORK_PATH', ROOT_PATH . 'framework/');
        define('TOOLS_PATH',FRAMEWORK_PATH . 'tools/');
        define('CAPTCHA_FONT',TOOLS_PATH.'captchafont/');
    }

/*
 * 初始化配置
 * */

private static function initConfig(){
    //存储于全局变量中，可以在整个项目中使用该全局变量
    $GLOBALS['config'] = require CONFIG_PATH.'application.config.php';
}
    /*
     * 初始化分发参数
     * */

    private static  function initDispatchParam(){
    // 确定分发参数
// 平台
    $default_platform = $GLOBALS['config']['app']['default_platform'];
    define('PLATFORM', isset($_GET['p']) ? $_GET['p'] : $default_platform);
// 控制器类
    $default_controller = $GLOBALS['config'][PLATFORM]['default_controller'];//获取当前平台的默认控制器
    define('CONTROLLER', isset($_GET['c']) ? $_GET['c'] : $default_controller);
// 动作
    $default_action = $GLOBALS['config'][PLATFORM]['default_action'];
    define('ACTION', isset($_GET['a']) ? $_GET['a'] : $default_action);
}


    /*
     * 声明当前平台路径常量
     * */
    private static function initPlatfromPathConst(){
        //当前平台相关的路径常量
        define('CURRENT_CONTROLLER_PATH', APPLICATION_PATH . PLATFORM . '/controller/');
        define('CURRENT_MODEL_PATH', APPLICATION_PATH . PLATFORM . '/model/');
        define('CURRENT_VIEW_PATH', APPLICATION_PATH . PLATFORM . '/view/');

    }


    /*
     * 注册自动加载
     * *
   */
    public static function initAutoLoad($class_name){
        // var_dump($class_name);echo '&nbsp;';
        //先处理确定的（框架中的核心类）
        // 类名与类文件映射数组
        $framework_class_list = array(
            // '类名' => '类文件地址'
            'Controller' 	=> FRAMEWORK_PATH . 'Controller.class.php',
            'Model' 		=> FRAMEWORK_PATH . 'Model.class.php',
            'Factory' 		=> FRAMEWORK_PATH . 'Factory.class.php',
            'MySQLDB' 		=> FRAMEWORK_PATH . 'MySQLDB.class.php',
            'SessionDB'   => TOOLS_PATH . 'SessionDB.class.php',
            'Captcha'     =>  TOOLS_PATH . 'Captcha.class.php',
            'Page'         => TOOLS_PATH . 'Page.class.php',
            'GetIp'        => TOOLS_PATH . 'GetIp.class.php',
        ) ;
        //判断是否为核心类
        if (isset($framework_class_list[$class_name])) {
            //是核心类
            require $framework_class_list[$class_name];
        }
        //判断是否为可增加（控制器类，模型类）
        //控制器类，截取后是个字符，匹配Controller
        elseif (substr($class_name, -10) == 'Controller') {
            // 控制器类， 当前平台下controller目录
            require CURRENT_CONTROLLER_PATH . $class_name . '.class.php';
        }
        //模型类，截取后5个字符，匹配Model
        elseif (substr($class_name, -5) == 'Model') {
            // 模型类，当前平台下model目录
            require CURRENT_MODEL_PATH . $class_name . '.class.php';
        }
    }
    private  static  function initSplAutoLoad(){
        spl_autoload_register(array(__CLASS__,'initAutoLoad'));
    }
     /*
     * 分发请求
     * */
     private static function initDispatch(){
         //实例化控制器类,并调用动作方法
         $controller_name = CONTROLLER . 'Controller';
//实例化
         $controller = new $controller_name();//可变类
//调用方法（action动作）
//拼凑当前的方法动作名字符串
         $action_name = ACTION . 'Action';
         $controller->$action_name();//可变方法
     }
}