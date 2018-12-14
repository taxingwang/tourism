<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;
use app\index\Model\IndexModel;
use think\Paginator;
class Index extends Controller
{
    //主页
    public function index()
    {
        $model = new IndexModel();
        if(!empty(Session::get("username"))){
            $username = Session::get("username");
            $this->assign("username",$username);
        }
        $indexlist = $model->showlist('spot');
        $routelist = $model->routedesc('route');
        $this->assign('routelist',$routelist);
        $this->assign('indexlist',$indexlist);
        return view();
    }
    //主页指定路线详情
    public function route(){
        $id = $_GET['id'];
        $model = new IndexModel();
        $route = $model->details('route','route_id',$id);
        $route_img = $model->imgss('route',$id);
        $model->click_num('route','route_id',$id,'click_num');
        $this->assign('route',$route);
        $this->assign('route_img',$route_img);
        return view();
    }

    //联系我们
    public function contact()
    {
        if(!empty(Session::get("username"))){
            $username = Session::get("username");
            $this->assign("username",$username);
        }
        return view();
    }

    //查询
    public function search(){
        $title = $_POST['title'];
        var_dump($title);
    }
    public function go_out(){
        Session::delete("user_id");
        $res = Session::delete("username");
        if($res==null){
            echo '<script>alert("已退出");location.href="Index/index"</script>';
        }else{
            echo '<script>alert("已退出");location.href="Index/index"</script>';
        }
    }
}
