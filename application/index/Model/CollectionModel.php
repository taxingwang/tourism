<?php 
namespace app\index\Model;
use think\Model;
use think\Db;
use think\Session;
use phpmailer\Email;
use think\Paginator;
use think\Cookie;
class CollectionModel extends Model{
    //用户点击收藏按钮收藏入库
    public function click_collection($table,$data){
        $res = Db::table($table)->insert($data);
        return $res;
    }
    //判断用户是否收藏
    public function is_collection($user_id,$route_id){
        $res = Db::table('collection')->where('user_id',$user_id)->where('route_id',$route_id)->find();
        return $res;
    }
    //取消收藏
    public function del($user_id,$route_id){
        $res = Db::table('collection')->where('user_id',$user_id)->where('route_id',$route_id)->delete();
        return $res;
    }
    //查询我的收藏
    public function My_collection($user_id){
        $res = Db::table('collection')->alias('a')->join('route b','a.route_id = b.route_id')->join('route_img c','b.route_id = c.r_id')->where('user_id',$user_id)->paginate(4);
        return $res;
    }
}