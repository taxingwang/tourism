<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;
use app\index\Model\LineModel;
use think\Paginator;
class Line extends Controller
{
	public function line(){
		$model = new LineModel();
		if(!empty(Session::get("username"))){
				$username = Session::get("username");
				$this->assign("username",$username);
			}
        $user_id = Session::get("user_id");
		if($_GET){
			if(isset($_GET['id'])){
				$id = $_GET['id'];
				$route = $model->UseIdGetRoute($id);
				$res = $model->is_collection($user_id,$id);
				if($res){
				    $status = 1; //已收藏
                }else{
				    $status = 0; //未收藏
                }
			}else{
				$route = $model->GetOneRoute();
                $res = $model->is_collection($user_id,$route['route_id']);
                if($res){
                    $status = 1; //已收藏
                }else{
                    $status = 0; //未收藏
                }
			}
		}else{
			$route = $model->GetOneRoute();
            $res = $model->is_collection($user_id,$route['route_id']);
            if($res){
                $status = 1; //已收藏
            }else{
                $status = 0; //未收藏
            }
		}
		$data = $model->GetRoutes();
		$this->assign("data",$data);
		$this->assign("route",$route);
		$this->assign("status",$status);
		return view();
	}
	public function search(){
		$model = new LineModel();
		if(!empty(Session::get("username"))){
				$username = Session::get("username");
				$this->assign("username",$username);
		}
		$search = $_POST['title'];
		$route = $model->Get_OneRoute($search);
		$data = $model->Get_Routes($search);
		$this->assign("data",$data);
		$this->assign("route",$route);
		return view();
	}
}