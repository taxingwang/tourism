<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use phpmailer\Email;
use think\Session;
use think\Cookie;
use app\Index\Model\SpotModel;
class Spot extends Controller
{
	public function Spot(){
		$model = new SpotModel();
		if(!empty(Session::get("username"))){
            $username = Session::get("username");
            $this->assign("username",$username);
        }
        $data = $model->GetSpot();
        $this->assign("data",$data);
        return view();
	}
	public function spot_details(){
        $id = $_GET['id'];
        $model = new SpotModel();
        if(!empty(Session::get("username"))){
            $username = Session::get("username");
            $this->assign("username",$username);
        }
        $spot = $model->details('spot','spot_id',$id);
        $imgs = $model->imgs('spot_imgs','spot_id',$id);
        $type = $model->class_type('spot',$id);
        $model->click_num('spot','spot_id',$id,'click_num');
        $this->assign('spot',$spot);
        $this->assign('imgs',$imgs);
        $this->assign('type',$type);
        return view();
    }
    public function get_spot_img(){
        $id = $_POST['id'];
        $spot_id = $_POST['spot_id'];
        $img = Db::table("spot_imgs")->where("id",$id)->where("spot_id",$spot_id)->column('spot_images');
        echo json_encode($img);
    }
    public function spot_point(){
        $model = new SpotModel();
        if(!empty(Session::get("user_id"))){
            $user_id = Session::get("user_id");
            $spot_id = $_POST['spot_id'];
            $points = $_POST['points'];
            $res = $model->SpotPoints($user_id,$spot_id,$points);
            echo $res;
        }else{
            echo 4;//用户没有登录
        }
    }
}