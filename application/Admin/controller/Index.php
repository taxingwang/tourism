<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Index extends Common
{
    public function index()
    {
    	return view();
    }
    //左侧菜单栏
    public function left(){
        $admin_id = Session::get("admin_id");
        $role = Db::table("admin_role")->where("admin_id=$admin_id")->find();
        $role_id = $role['role_id'];
        if($role_id==1){
            $access = Db::table("access")->select();
        }else{
            $role_access = Db::table("role_access")->where("role_id='$role_id'")->select();
            $access_ids = "";
            foreach ($role_access as $key => $value) {
                $access_ids .=",".$value['access_id'];
            }
            $access_id = ltrim($access_ids,",");
            $where["access_id"] = array("in","$access_id");
            $access = Db::table("access")->where($where)->select();
        }
        $data = array();
        foreach ($access as $key => $value) {
            if($value['parent_id']==0){
                $data[$key]=$value;
                foreach ($access as $k => $val) {
                    if($value['access_id']==$val['parent_id']){
                        $data[$key]['son'][$k] = $val;
                    }
                }
            }
        }
        $this->assign("data",$data);
    	return view();
    }
    //头部
    public function head(){
        $accounts = Session::get("accounts");
        $this->assign("accounts",$accounts);

    	return view();
    }
    //主体
    public function main(){
    	return view();
    }
}
