<?php 
namespace app\index\Model;
use think\Model;
use think\Db;
use think\Session;
use phpmailer\Email;
use think\Paginator;
use think\Cookie;
class NewsModel extends Model{
    //根据点击次数倒叙查询新闻
    public function Getnews(){
        return Db::table('news')->order('new_click desc')->where('new_status',0)->paginate(5);
    }
    //根据时间查询最新的4条新闻
    public function Timenews(){
        return Db::table('news')->order('new_time desc')->where('new_status',0)->limit(4)->select();
    }
    //查询该新闻的详细信息
    public function Get_new($id){
        return Db::table('news')->where('new_id',$id)->select();
    }
    //用户每点击一次自增点击量
    public function new_click($id){
        return Db::table('news')->where('new_id',$id)->setInc('new_click');
    }
}