<?php 
namespace app\index\Model;
use think\Model;
use think\Db;
use think\Session;
use think\Paginator;
class SpotModel extends Model{
	//景点列表
	public function GetSpot(){
		return $data = Db::table("spot_imgs")->alias("si")->join("spot s","si.spot_id=s.spot_id")->where("is_host",1)->paginate(12);
	}
	//查询线路详情
    public function details($table,$ids,$id){
	  	return $rou = Db::table($table)->where($ids,$id)->find();
	    
    }
    //查询路线的图片
    public function imgss($table,$id){
        return $spot = Db::table($table)->alias('a')->join('route_img b','a.route_id = b.r_id')->where('route_id',$id)->limit(4)->find();
    }

    //查询景点详情的图片
    public function imgs($table,$ids,$id){
        return $rou = Db::table($table)->where($ids,$id)->select();
    }
    //更改景点表中的浏览次数
    public function click_num($table,$ids,$id,$click){
        return $data = Db::table($table)->where($ids, $id)->setInc($click);
    }
    //查询景点分类
    public function class_type($table,$id){
        return $data = Db::table($table)->alias('a')->join('spot_class b','a.spot_type_id = b.class_id')->where('spot_id',$id)->find();
    }
    //评分
    public function SpotPoints($user_id,$spot_id,$points){
        $data = ['user_id'=>$user_id,'spot_id'=>$spot_id,'points'=>$points,'time'=>date("Y-m-d H:i:s")];
        $res1 = Db::table("spot_points")->where("user_id",$user_id)->where("spot_id",$spot_id)->find();
        if($res1){
            return 3;//对该景点已经评分过
        }else{
            $res = Db::table("spot_points")->insert($data);
            if($res){
                $count = Db::table("spot_points")->where("spot_id",$spot_id)->count();
                $sum = Db::table("spot_points")->where("spot_id",$spot_id)->sum("points");
                $spot_point = number_format($sum/$count,"1");
                $update = ['spot_point'=>$spot_point];
                return $str = Db::table("spot")->where("spot_id",$spot_id)->update($update);
            }else{
                return 2;
            }
        }
        
    }
}