<?php
namespace app\index\controller;
use app\index\Model\NewsModel;
use think\Controller;
use think\Db;
use think\Session;
use app\index\Model\IndexModel;
use think\Paginator;
class News extends Controller
{
    //公司新闻
    public function new_list()
    {
        $model = new NewsModel();
        if(!empty(Session::get("username"))){
                $username = Session::get("username");
                $this->assign("username",$username);
            }
        $news = $model->Getnews();
        $timenews = $model->Timenews();
        $this->assign('news',$news);
        $this->assign('timenews',$timenews);
    	return view();
    }
    //新闻详情
    public function news_get(){
        $id = $_GET['id'];
        $model = new NewsModel();
        $new = $model->Get_new($id);
        $model->new_click($id);
        $this->assign('new',$new);
        return view();
    }
}
