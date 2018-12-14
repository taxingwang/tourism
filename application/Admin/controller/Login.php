<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Login extends Controller{
	//管理员登录界面
	public function login(){
		return view();
	}
	//登录验证
	public function login_do(){
		$data = $_POST;
		$admin_pwd = md5($data['admin_pwd']);
		$arr = Db::table('admin')->where('accounts',$data['accounts'])->find();
		if($arr){
			if($arr['admin_pwd']==$admin_pwd){
				if($arr['status']==0){
					echo 0;
				}else{
					$res = Db::table('admin')->where('admin_id',$arr['admin_id'])->update(['last_time'=>date("Y-m-d H:i:s")]);
						Session::set("accounts",$arr["accounts"]);
						Session::set("admin_id",$arr["admin_id"]);
						echo 1;
				}
				
			}else{
				echo 3;
			}
		}else{
			echo 2;
		}
	}
	//修改密码
	public function change_pwd(){
		$admin = Session::get("accounts");
		$this->assign('admin',$admin);
		return view();
	}
	//密码验证
	public function pwd_check(){
		$pwd = $_POST['pwd'];
		
		$accounts = Session::get("accounts");
		$data = Db::table("admin")->where("accounts",$accounts)->find();
		if($data['admin_pwd']==md5($pwd)){
			echo 1;
		}else{
			echo 0;
		}
	}
	//修改密码方法
	public function change_pwd_do(){
		$new_pwd = $_POST['new_pwd'];
		$admin_pwd = $_POST['admin_pwd'];
		$admin_id = Session::get("admin_id");
		$where = [
			"admin_id"=>$admin_id,
			"admin_pwd"=>$admin_pwd
		];
		$res = Db::table("admin")->where($where)->update(['admin_pwd'=>md5($new_pwd)]);
		if($res){
			echo 1;
		}else{
			echo 0;
		}
	}
	//管理员退出
	public function go_out(){
		Session::delete("accounts");
		$res = Session::delete("admin_id");
		if($res==null){
			echo '<script>alert("已退出");location.href="Login/login"</script>';
		}else{
			echo '<script>alert("已退出");location.href="Login/login"</script>';
		}
	}
}