<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Admin extends Common
{
	public function adminList(){
		return view();
	}
	public function access(){
		return view();
	}
	public function role(){
		return view();
	}
}