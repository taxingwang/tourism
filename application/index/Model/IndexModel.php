<?php 
namespace app\index\Model;
use think\Model;
use think\Db;
use think\Session;
use think\Paginator;
class IndexModel extends Model{
    //主页景点
	public function showlist($table){
        $data = Db::table($table)->alias("s")->join("spot_class sc","s.spot_type_id=sc.class_id")->join("spot_imgs si","s.spot_id=si.spot_id")->where("is_host",1)->limit(6)->select();
       return $data;
    }
    //主页右侧线路前三名
    public function routedesc($table){
        $spot = Db::table($table)->alias('a')->join('route_img b','a.route_id = b.r_id')->order('click_num desc')->limit(3)->select();
        return $spot;
    }
    //查询线路详情
    public function details($table,$ids,$id){
	    $rou = Db::table($table)->where($ids,$id)->find();
	    return $rou;
    }
    //查询路线的图片
    public function imgss($table,$id){
        $spot = Db::table($table)->alias('a')->join('route_img b','a.route_id = b.r_id')->where('route_id',$id)->limit(4)->find();
        return $spot;
    }

    //查询景点详情的图片
    public function imgs($table,$ids,$id){
        $rou = Db::table($table)->where($ids,$id)->select();
        return $rou;
    }
    //更改景点表中的浏览次数
    public function click_num($table,$ids,$id,$click){
        $data = Db::table($table)->where($ids, $id)->setInc($click);
        return $data;
    }
    //查询景点分类
    public function class_type($table,$id){
        $data = Db::table($table)->alias('a')->join('spot_class b','a.spot_type_id = b.class_id')->where('spot_id',$id)->find();
        return $data;
    }
}
 ?>