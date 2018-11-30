<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Login{
	public function login(){
		return view();
	}
	public function login_do(){
		$data = $_POST;
		$admin_pwd = md5($data['admin_pwd']);
		$arr = Db::table('admin')->where('accounts',$data['accounts'])->find();
		if($arr){
			if($arr['admin_pwd']==$admin_pwd){
				$res = Db::table('admin')->where('admin_id',$arr['admin_id'])->update(['last_time'=>date("Y-m-d H:i:s")]);
				Session::set("accounts",$arr["accounts"]);
				Session::set("admin_id",$arr["admin_id"]);
				echo 1;
			}else{
				echo 3;
			}
		}else{
			echo 2;
		}
	}
}