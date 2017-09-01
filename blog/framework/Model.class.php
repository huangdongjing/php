<?php


/**
 * 基础模型类
 */
class Model {
	protected $_dao;//存储DAO对象的属性，可以在子类方法中被访问，使用DAO对象

	/**
	 * 初始化DAO
	 */
	protected function _initDAO() {
				//初始化MySQLDB
		$config = $GLOBALS['config']['db'];
        $this->_dao = MySQLDB::getInstance($config);//$dao , Database Access Object 数据库操作对象（dao层）
	}

	/**
	 * 构造方法
	 */
	public function __construct() {
		// 初始化DAO
		$this->_initDAO();
	}

	/*
	 *转义数组内的全部元素
	 *@param $data array
	 *@return array
	 * */
	protected function escapeStringAll($data){
	    foreach ($data as $key => $value){
	        $data[$key] = $this->_dao->escapeString($value);
        }
        return $data;
    }
}