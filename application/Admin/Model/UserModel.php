<?php 
namespace app\admin\Model;
use think\Model;
use think\Db;
use think\Session;
use think\Paginator;
class UserModel extends Model{
	public function change_user_status($user_id,$status){
		if($status==1){
			return $res = Db::table("user")->where("user_id",$user_id)->update(['user_status'=>0]);
        }else{
			return $res = Db::table("user")->where("user_id",$user_id)->update(['user_status'=>1]);
        }
	}
}