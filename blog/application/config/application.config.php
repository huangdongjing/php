<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/8
 * Time: 20:37
 */
return array(
    'db'  => array(              //数据库信息组
        'host'  =>  '127.0.0.1',
        'port'  =>  '3306',
        'username'  =>  'root',
        'password'  =>  '123',
        'charset'  =>  'utf8',
        'dbname'  =>  'aiyayablog',
    ),

    'app'  => array(             //应用程序组
        'default_platform'       =>  'front',
    ),
    'back'  =>  array(          //后台组

        'default_controller'     =>     'Manage',
        'default_action'         =>      'index',
    ),
    'front'  =>  array(        //前台组
        'default_controller'     =>     'Manage',
        'default_action'         =>      'index',
    )

);