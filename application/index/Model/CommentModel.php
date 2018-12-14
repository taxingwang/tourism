<?php 
namespace app\index\Model;
use think\Model;
use think\Db;
use think\Session;
use phpmailer\Email;
use think\Paginator;
use think\Cookie;
class CommentModel extends Model{
    //查询出所有的景点
    public function spot_list(){
        return $data = Db::table("spot_imgs")->alias("si")->join("spot s","si.spot_id=s.spot_id")->where("is_host",1)->paginate(12);
    }
    //查询出该景点下的所有评论
    public function Getcomment($id){
        return $data = Db::table('comment')->alias('a')->join('spot b','a.spot_id = b.spot_id')->join('user c','a.user_id = c.user_id')->order('com_time desc')->where('a.spot_id',$id)->paginate(5,true,['query'=>['id'=>$id]]);
    }
    //添加评论
    public function insert_comment($table,$data){
        return Db::table($table)->insert($data);
    }
}