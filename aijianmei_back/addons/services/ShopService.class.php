<?php
session_start();
/**
 * 商城登录服务
 */
class ShopService extends Service {
	public function is_registered($username, $email, $password){
		
	}
	// 注册商城用户
	public function register($username, $email, $password){
		M('')->query('insert into ecs_users (`user_name`,`email`,`password`,`reg_time`,`last_login`) values ("'.$username.'","'.$email.'","'.$password.'",'.time().','.time().')');
		$id = M('')->query('select user_id,user_name from ecs_users where user_name="'.$username.'"');
		
		$this->_login($id[0]['user_id'], $id[0]['user_name']);
	}
	// 登录商城
	public function login($id){
		$user = M('user')->where(array('uid'=>$id))->find();
		$uid = M('')->query('select user_id,user_name from ecs_users where user_name="'.$user['uname'].'"');
		
		if(!$uid[0]['user_id']) {
			$this->register($user['uname'], $user['email'], $user['password']);	
		}else {
			$this->_login($uid[0]['user_id'], $uid[0]['user_name']);
		}		
	}
	// 登出商城
	public function logout(){
		$_SESSION['user_id'] = '';	
		$_SESSION['user_name'] = '';
	}
	public function check_email(){}
	private function _login($uid, $uname)
	{
		$_SESSION['user_id'] = $uid;
		$_SESSION['user_name'] = $uname;
	}
	
	/* 后台管理相关方法 */

	// 运行服务，系统服务自动运行
	public function run() {
		return;
	}
}
?>