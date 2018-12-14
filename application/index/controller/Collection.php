<?php
namespace app\index\controller;
use app\index\Model\CollectionModel;
use think\Controller;
use think\Db;
use think\Session;
use app\index\Model\LineModel;
use think\Paginator;
class Collection extends Controller
{
    //收藏
	public function collection(){
		$model = new CollectionModel();
		if(!empty(Session::get("username"))){
		    $username = Session::get("username");
		    $this->assign("username",$username);
		}
        $user_id = Session::get('user_id');
		$route_id = $_POST['route_id'];
		$res = $model->is_collection($user_id,$route_id);
        if($user_id == null){
            echo 0; //判断是否登录 如果未登录则返回去登录
        }else if($res){
            $re = $model->del($user_id,$route_id);
            if($re){
                echo 3;
            }else{
                echo 4;
            }
        }else{
            $data = [
                'user_id' => $user_id,
                'route_id' => $route_id,
                'coll_time' => date("Y-m-d H:i:s")
            ];
            $res = $model->click_collection('collection',$data);
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }
	}
	//查询该用户下的所有的收藏
    public function my_collection(){
        $model = new CollectionModel();
        if(!empty(Session::get("username"))){
            $username = Session::get("username");
            $this->assign("username",$username);
        }
        $user_id = Session::get('user_id');
        if($user_id == null){
            echo "<script>alert('请先登录');location.href=\"http://www.tours.com/index/login/login.html\"</script>";//判断是否登录 如果未登录则返回去登录
        }else{
            $data = $model->My_collection($user_id);
            $this->assign('data',$data);
            return view();
        }
    }
}