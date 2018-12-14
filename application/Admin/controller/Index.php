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
            $access = Db::table("access")->where("access_status",1)->select();
        }else{
            $access_id = Db::table("role_access")->where("role_id='$role_id'")->column('access_ids');
            $access_ids = $access_id[0];
            // var_dump($access_ids);die;
            $where["access_id"] = array("in","$access_ids");
            $access = Db::table("access")->where($where)->where("access_status",1)->select();
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
        $admin_id = Session::get("admin_id");
        $accounts = Session::get("accounts");
        $data = Db::table("admin_role")->alias("a")->join("role r","a.role_id=r.role_id")->where("admin_id",$admin_id)->column('role_name');
        
        $this->assign("role_name",$data[0]);
        $this->assign("accounts",$accounts);

    	return view();
    }
    //主体
    public function main(){
    	return view();
    }
}
