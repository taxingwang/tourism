<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class System extends Common
{
	public function goOut(){
		Session::delete("accounts");
		Session::delete("admin_id");
		$this->success("已退出",Url('Login/login'));
	}
}