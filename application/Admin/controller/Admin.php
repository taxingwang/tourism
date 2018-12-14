<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
use app\Admin\Model\AdminModel;
use think\Paginator;
class Admin extends Common
{
//后台帐号列表

    public function adminlist(){
        $adminlist = Db::table('admin')
            ->alias('a')
            ->join('admin_role b','a.admin_id = b.admin_id')
            ->join('role c','b.role_id = c.role_id')
            ->where('is_admin',0)
            ->order('is_admin asc')
            ->paginate(5);
        $where = "role_id!=1";
        $rolelist = Db::table('role')->where($where)->where("role_status",1)->select();
        $this->assign('adminlist',$adminlist);
        $this->assign('rolelist',$rolelist);
        return view();
    }

//删除账号
    public function admin_del(){
        $admin_id = $_POST['admin_id'];
        $where = "admin_id=$admin_id";
        $res = Db::table('admin')->where($where)->delete();
        $res1 = Db::table('admin_role')->where("admin_id",$admin_id)->delete();
        if($res&&$res1){
            echo 0;
        }else{
            echo 1;
        }
    }

//添加账号
    public function admin_add(){
        $accounts = $_POST['accounts'];
        $password = $_POST['password'];
        $str = Db::table("admin")->where("accounts",$accounts)->find();
        if($str){
        	echo 1;//该账号已经存在
        }else{
        	$data = [
            'accounts' => $accounts,
            'admin_pwd' => md5($password),
            'is_admin' => 0,
            'status' => 1
	        ];
	        $res = Db::table('admin')->insert($data);
	        $admin_id = Db::name('admin')->getLastInsID();
	        $role_id = $_POST['role_id'];
	        $role = [
	            'admin_id' => $admin_id,
	            'role_id' => $role_id,
	            'admin_role_time' => date("Y-m-d H:i:s"),
	        ];

	        Db::table('admin_role')->insert($role);
	        if($res){
	            echo 2;
	        }else{
	            echo 3;
	        }
        }
    }

//修改后台管理员的角色
    public function admin_save(){
        $role_id = $_POST['role_id'];
        $admin_id = $_POST['admin_id'];
        $where = "admin_id=$admin_id";
        $save = [
            'role_id' => $role_id
        ];
        $res = Db::table('admin_role')->where($where)->update($save);
        if($res){
            echo 0;
        }else{
            echo 1;
        }
    }
    public function change_access_status(){
        $access_id = $_POST['access_id'];
        $access_status =$_POST['access_status'];
        $where = ["parent_id"=>$access_id,"access_status"=>1];
        $child = Db::table("access")->where($where)->select();
        if($child){
            echo 2;
        }else{
            if($access_status==1){
                $res = Db::table("access")->where("access_id",$access_id)->update(['access_status'=>0]);
            }else{
                $res = Db::table("access")->where("access_id",$access_id)->update(['access_status'=>1]);
            }
            if($res){
                echo 1;
            }else{
                echo 0;
            }
        }
    }

    public function role_access(){
        $access = Db::table("access")->select();
        $data = [];
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
        $role = Db::table("role")->where("role_id","NEQ",1)->select();
        $this->assign("data",$data);
        $this->assign("role",$role);
        return view();
    }
    public function getAccess(){
        $role_id = $_POST['role_id'];
        $access_id = Db::table("role_access")->where("role_id",$role_id)->column('access_ids');
        
        if($access_id){
            $access_ids = explode(",",$access_id[0]);
            sort($access_ids);
        }else{
            $access_ids = [];
        }
        echo json_encode($access_ids);

    }
    //权限管理
    public function change_RoleAccess(){
        $role_id = $_POST['role_id'];
        $access_id = $_POST['access_ids'];
        $arr = rtrim($access_id,",");
        $access_ids = explode(",",$arr);
        asort($access_ids);
        $access_ids = implode(",",$access_ids);
        $model = new AdminModel();
        $res = $model->change_role_access($role_id,$access_ids);
        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }
    //修改角色状态
    public function change_RoleStatus(){
        $model = new AdminModel();
        $role_id = $_POST['role_id'];
        $role_status = $_POST['role_status'];
        $res = $model->change_role_status($role_id,$role_status);
        echo $res;
    }
    //修改后台用户状态
    public function change_AdminStatus(){
        $model = new AdminModel();
        $admin_id = $_POST['admin_id'];
        $status = $_POST['status'];
        $res = $model->change_admin_status($admin_id,$status);
        echo $res;
    }
    //权限添加
    public function access_add(){
        $parent = Db::table("access")->where("parent_id",0)->select();
        $access = Db::table("access")->paginate(9);
        $this->assign("access",$access);
        $this->assign("parent",$parent);
        return view();
    }
    public function access_add_do(){
        $data = $_POST;
        $data['creat_access_time'] = date("Y-m-d H:i:s");
        $res = Db::table('access')
                ->where('access_name',$data['access_name'])
                ->where('functions',$data['functions'])
                ->find();
        if($res){
            echo 2;//权限或方法名已存在
        }else{
            $str = Db::table("access")->insert($data);
            if($str){
                echo 1;
            }else{
                echo 0;
            }
        }
    }
    //角色管理--角色列表
    public function role(){
        $where = "role_id!=1";
        $rolelist = Db::table('role')->where($where)->select();
        $this->assign('rolelist',$rolelist);
        return view();
    }

//角色管理--添加角色
    public function role_add(){
        $role_name = $_POST['role_name'];
        $where = "role_name=$role_name";
        $ss = Db::table('role')->where($where)->find();
        if($ss){
            echo 3;
        }else if(empty($role_name)){
            echo 0;
        }else{
            $data = [
                'role_name' => $role_name,
                'creat_role_time' => date("Y-m-d H:i:s")
            ];
            $res = Db::table('role')->insert($data);
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }
    }

//角色管理--删除角色
    public function role_del(){
        $role_id = $_POST['role_id'];
        $where = "role_id=$role_id";
        $res = Db::table('role')->where($where)->delete();
        if($res){
            echo 0;
        }else{
            echo 1;
        }
    }

//修改角色
    public function role_save(){
        $role_id = $_POST['role_id'];
        $role_name = $_POST['role_name'];
        $res = Db::table("role")->where("role_id",$role_id)->update(['role_name'=>$role_name]);
        if($res){
            echo 1;
        }else{
            echo 0;
        }
    }

}