<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Spot extends Common
{
	public function spot_add(){
		$type = Db::table("spot_class")->select();
		$areas = Db::table("areas")->where("parent_id",0)->select();
		$this->assign("areas",$areas);
		$this->assign("type",$type);
		return view();
	}
	public function get_area(){
		$parent_id = $_POST['parent_id'];
		$data = Db::table("areas")->where("parent_id",$parent_id)->select();
		echo json_encode($data);
	}
}