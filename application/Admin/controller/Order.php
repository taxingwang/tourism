<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Order extends Common
{
	public function order(){
		return view();
	}
	public function order_log(){
		return view();
	}
}