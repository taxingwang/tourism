<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
use think\File;
use think\Paginator;
class Spot extends Common
{
	//景点添加页面
	public function spot_add(){
		$type = Db::table("spot_class")->select();
		$areas = Db::table("areas")->where("parent_id",0)->select();
		$this->assign("areas",$areas);
		$this->assign("type",$type);
		return view();
	}
	//景点添加方法
	public function spot_add_do(){
		$data = $_POST;
		$res = Db::table("spot")->insert($data);
		if($res){
			echo 1;
		}else{
			echo 2;
		}
	}
	//获取地区下拉框
	public function get_area(){
		$parent_id = $_POST['parent_id'];
		$data = Db::table("areas")->where("parent_id",$parent_id)->select();
		echo json_encode($data);
	}
	//景点列表
	public function spot_list(){
		$data = Db::table("spot")->alias("s")->join("spot_class sc","s.spot_type_id=sc.class_id")->join("spot_imgs si","s.spot_id=si.spot_id")->where("is_host",1)->paginate(3);
		$this->assign("data",$data);
		return view();
	}
	public function spot(){
		$data = Db::table("spot")->alias("s")->join("spot_class sc","s.spot_type_id=sc.class_id")->paginate(5);
		$this->assign("data",$data);
		return view();
	}
	//景点图片添加页面
	public function spot_img_add(){
		$spot_id = $_GET['id'];
		$data = Db::table("spot")->where("spot_id",$spot_id)->find();
		$this->assign("data",$data);
		return view();
	}
	//景点图片添加方法
	public function img_add_do(){
		$data = $_POST;
		if($data['is_host']==1){
			$where['spot_id']=$data['spot_id'];
			$where['is_host']=1;
			$str = Db::table("spot_imgs")->where($where)->find();
			if($str){
				echo '<script>alert("该景点已有主图");location.href="Spot/spot_img_add"</script>';
			}else{
				$file = request()->file('img');
				$spot_images = $this->upload($file);
				$data["spot_images"] = $spot_images;
				$res = Db::table("spot_imgs")->insert($data);
				if($res){
					$this->success("添加成功",("Spot/spot"));
				}else{
					$this->error("添加失败");
				}
			}
		}else{
			$file = request()->file('img');
			$spot_images = $this->upload($file);
			$data["spot_images"] = $spot_images;
			$res = Db::table("spot_imgs")->insert($data);
			if($res){
				$this->success("添加成功",("Spot/spot"));
			}else{
				$this->error("添加失败");
			}
		}
	}
	//路线管理
	public function way(){
		$data = Db::table("route")->select();
		foreach ($data as $key => $value) {
			$spot_ids = $value['spots'];
			$arr = Db::table("spot")->where("spot_id","in",$spot_ids)->column('spot_name');
			$data[$key]["spot_names"]=$arr;
		}
		// echo "<pre>";
		// print_r($data);
		$this->assign("data",$data);
		return view();
	}
	//路线添加页面（列出所有景点）
	public function way_add(){
		$spot = Db::table("spot")->select();
		$class = Db::table("spot_class")->select();
		$class_count = count($class);
		$spot_count = count($spot);
		for($j=0;$j<$class_count;$j++){
			for($i=0;$i<$spot_count;$i++){
				if($spot[$i]["spot_type_id"]==$class[$j]["class_id"]){
					$class[$j]["son"][] = $spot[$i];
				}
			}
		}
		$this->assign("class",$class);
		return view();
	}
	//路线添加方法
	public function way_add_do(){
		$data = $_POST;
		$data['spots'] = rtrim($data['spots'],",");
		$data['creat_time'] = date("Y-m-d H:i:s");
		$res = Db::table("route")->insert($data);
		if($res){
			echo 1;
		}else{
			echo 0;
		}
	}
	//更改景点状态
	public function change_status(){
		$spot_id = $_POST['spot_id'];
		$status =$_POST['status'];
		if($status==1){
			$res = Db::table("spot")->where("spot_id",$spot_id)->update(['spot_status'=>0]);
		}else{
			$res = Db::table("spot")->where("spot_id",$spot_id)->update(['spot_status'=>1]);
		}
		if($res){
			echo 1;
		}else{
			echo 0;
		}
	}
	//景点详情
	public function spot_details(){
		$spot_id = $_GET['id'];
		$data = Db::table("spot")->alias("s")->join("areas a","s.area_id=a.area_id")->join("spot_class sc","s.spot_type_id=sc.class_id")->where("spot_id",$spot_id)->find();
		$dataImg = Db::table("spot_imgs")->where("spot_id",$spot_id)->select();
		$this->assign("data",$data);
		$this->assign("dataImg",$dataImg);
		return view();
	}
	//路线封面上传页面
    public function way_img_add(){
	    $route_id = $_GET['id'];
        $data = Db::table("route")->where("route_id",$route_id)->find();
        $this->assign("data",$data);
        return view();
    }
    //路线封面上传
    public function way_img_add_do(){
	    $r_id = $_POST['route_id'];
        $data = ['r_id' => $r_id];
        $where['r_id']=$r_id;
        $file = request()->file('route_imgs');
        $route_imgs = $this->upload($file);
        $str = Db::table("route_img")->where($where)->find();
        if($str){
            $re = Db::table('route_img')->where($where)->update(['route_imgs' => $route_imgs]);
            if($re){
                $this->success("替换成功",("Spot/way"));
            }else{
                $this->error("替换失败");
            }
        }else{
            $data["route_imgs"] = $route_imgs;
            $res = Db::table("route_img")->insert($data);
            if($res){
                $this->success("设置成功",("Spot/way"));
            }else{
                $this->error("设置失败");
            }
        }
    }
	//文件上传
	public function upload($file){
    // 移动到框架应用根目录/public/uploads/ 目录下
    if($file){
        $info = $file->move(ROOT_PATH . 'public'. DS . 'admin');
        if($info){
            // 成功上传后 获取上传信息
            return $info->getSaveName();
        }else{
            // 上传失败获取错误信息
            return $file->getError();
        }
    }
}
}