<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
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
        $rolelist = Db::table('role')->where($where)->select();
        $this->assign('adminlist',$adminlist);
        $this->assign('rolelist',$rolelist);
        return view();
    }

    //删除账号
    public function admin_del(){
        $admin_id = $_POST['admin_id'];
        $where = "admin_id=$admin_id";
        $res = Db::table('admin')->where($where)->delete();
        if($res){
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

    //权限管理
    public function access(){
        echo 1111;
    }

    //角色管理
    public function role(){
        $where = "role_id!=1";
        $rolelist = Db::table('role')->where($where)->select();
        $this->assign('rolelist',$rolelist);
        return view();
    }

    //添加角色
    public function role_add(){
        $role_name = $_POST['role_name'];
        if(empty($role_name)){
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

    //删除角色
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
}