<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Comment extends Common {
    //查询所有的景点
    public function comment_list(){
        $spot = Db::table('spot')->alias('a')->join('spot_class b','a.spot_type_id = b.class_id')->order('click_num desc')->paginate(5);
        $this->assign('spot',$spot);
        return view();
	}
	//查询每一个景点的评论
    public function Get_comment(){
        $id = $_GET['id'];
        $comment = Db::table('comment')->alias('a')->join('spot b','a.spot_id = b.spot_id')->join('user c','a.user_id = c.user_id')->order('com_time desc')->where('a.spot_id',$id)->paginate(5,true,['query'=>['id'=>$id]]);
        $this->assign('comment',$comment);
        return view();
    }
    //删除评论
    public function comment_del(){
        $id = $_POST['id'];
        $res = Db::table('comment')->where('com_id',$id)->delete();
        if($res){
            echo 0;
        }else{
            echo 1;
        }
    }
}