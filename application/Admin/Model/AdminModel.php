<?php 
namespace app\admin\Model;
use think\Model;
use think\Db;
use think\Session;
use think\Paginator;
class AdminModel extends Model{
	public function change_role_access($role_id,$access_ids){
		$res = Db::table("role_access")->where("role_id",$role_id)->select();
		$data = ["role_id"=>$role_id,"access_ids"=>$access_ids,"role_access_time"=>date("Y-m-d H:i:s")];
		$data1 = ["access_ids"=>$access_ids,"role_access_time"=>date("Y-m-d H:i:s")];
		if($res){
			return $str = Db::table("role_access")->where("role_id",$role_id)->update($data1);
		}else{
			return $str = Db::table("role_access")->insert($data);
		}
	}
	public function change_role_status($role_id,$role_status){
		$arr = Db::table("admin_role")->where("role_id",$role_id)->select();
		if($arr){
			return 3;
		}else{
			if($role_status==1){
				return $res = Db::table("role")->where("role_id",$role_id)->update(['role_status'=>0]);
            }else{
				return $res = Db::table("role")->where("role_id",$role_id)->update(['role_status'=>1]);
            }
		}
	}
	public function change_admin_status($admin_id,$status){
		if($status==1){
			return $res = Db::table("admin")->where("admin_id",$admin_id)->update(['status'=>0]);
        }else{
			return $res = Db::table("admin")->where("admin_id",$admin_id)->update(['status'=>1]);
        }
	}
}
 ?>