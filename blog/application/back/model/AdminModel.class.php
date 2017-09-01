<?php

/**
 * admin表操作模型
 */
class AdminModel extends Model {
	/**
	 * 验证管理员是否合法
	 *
	 * @param $admin_name
	 * @param $admin_pass
	 *
	 * @return bool
	 */
	public function check($admin_name, $admin_pass) {
	    $admin_name_escape = $this->_dao->escapeString($admin_name);
        $admin_pass_escape = $this->_dao->escapeString($admin_pass);

        $sql = "SELECT * FROM `yy_admin` WHERE admin_name=$admin_name_escape and admin_pwd=md5($admin_pass_escape)";
		//die($sql);
		$row = $this->_dao->getRow($sql);

		return $row;
	}
}