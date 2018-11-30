<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class Admin extends Common
{
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


        if(empty($accounts)){
            echo 0;
        }else if(empty($password)){
            echo 1;
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
}