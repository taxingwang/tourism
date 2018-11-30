<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Common extends Controller{

    public function _initialize(){
		if(Session::get("accounts")==null){
			$this->success("请先登录",Url('Login/login'));
		}
	}
    
}