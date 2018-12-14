<?php 
namespace app\index\Model;
use think\Model;
use think\Db;
use think\Session;
use think\Paginator;
class LineModel extends Model{
	public function GetRoutes(){
		return $data = Db::table("route")->alias("r")->join("route_img ri","r.route_id=ri.r_id")->order("click_num desc")->paginate(4);
	}
	public function GetOneRoute(){
		return $data = Db::table("route")->alias("r")->join("route_img ri","r.route_id=ri.r_id")->order("click_num desc")->limit(1)->find();
	}
	public function UseIdGetRoute($id){
		return $data = Db::table("route")->alias("r")->join("route_img ri","r.route_id=ri.r_id")->where("route_id",$id)->find();
	}
	public function Get_OneRoute($search){
		return $data = Db::table("route")->alias("r")->join("route_img ri","r.route_id=ri.r_id")->where("route_name","like","%".$search."%")->order("click_num desc")->limit(1)->find();
	}
	public function Get_Routes($search){
		return $data = Db::table("route")->alias("r")->join("route_img ri","r.route_id=ri.r_id")->where("route_name","like","%".$search."%")->order("click_num desc")->paginate(4);
	}
	public function is_collection($user_id,$route_id){
        return $res = Db::table('collection')->where('user_id',$user_id)->where('route_id',$route_id)->find();
    }
}

 ?>