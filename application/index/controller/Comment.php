<?php
namespace app\index\controller;
use app\index\Model\CommentModel;
use think\Controller;
use think\Db;
use think\Session;
use app\index\Model\IndexModel;
use think\Paginator;
class Comment extends Controller
{
    //展示出所有的景点
    public function comment()
    {
        $model = new CommentModel();
        if(!empty(Session::get("username"))){
            $username = Session::get("username");
            $this->assign("username",$username);
        }
        $data = $model->spot_list();
        $this->assign('data',$data);
        return view();
    }
    //点击每一个景点查询出该景点下的所有评论
    public function comment_list(){
        $model = new CommentModel();
        if(!empty(Session::get("username"))){
            $username = Session::get("username");
            $this->assign("username",$username);
        }
        $id = $_GET['id'];
        $comment = $model->Getcomment($id);
        $this->assign('comment',$comment);
        $this->assign('id',$id);
        return view();
    }
    //评论该景点
    public function com(){
        $model = new CommentModel();
        if(empty(Session::get("username"))){
            echo 0;//判断是否登录 如果未登录则返回去登录
        }else{
            $user_id = Session::get('user_id');
            $data = [
                'user_id' => $user_id,
                'spot_id' => $_POST['spot_id'],
                'com_content' => preg_replace('# #','',$_POST['val']),
                'is_show' =>$_POST['is_show'],
                'com_time' => date("Y-m-d H:i:s"),
            ];
            $res = $model->insert_comment('comment',$data);
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }
    }
}
