<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
class Index extends Common
{
    public function index()
    {
    	return view();
    }
    public function left(){
         $u_id = $_SESSION['u_id'];
        $role = M("user_role")->where("u_id=$u_id")->find();
        $role_id = $role['role_id'];
        if($role_id==1){
            $access = M("access")->select();
        }else{
            $role_access = M("role_access")->where("role_id='$role_id'")->select();
            $access_ids = "";
            foreach ($role_access as $key => $value) {
                $access_ids .=",".$value['access_id'];
            }
            $access_id = ltrim($access_ids,",");
            $where["a_id"] = array("in","$access_id");
            $access = M("access")->where($where)->select();
        }
        $data = array();
        foreach ($access as $key => $value) {
            if($value['parents_id']==0){
                $data[$key]=$value;
                foreach ($access as $k => $val) {
                    if($value['a_id']==$val['parents_id']){
                        $data[$key]['son'][$k] = $val;
                    }
                }
            }
        }
        $this->assign("data",$data);
        $this->display();
    	return view();
    }
    public function head(){
    	return view();
    }
    public function main(){
    	return view();
    }
}
