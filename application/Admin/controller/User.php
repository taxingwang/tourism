<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
use app\Admin\Model\UserModel;
class User extends Common
{
    //前台用户列表
   public function userlist(){
       $userlist = Db::table('user')->order('user_id asc')->paginate(5);;
       $this->assign('userlist',$userlist);
       return view();
   }

   //后台添加前台用户
    public function user_add(){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $str = Db::table("user")->where("username",$username)->find();
        if($str){
            echo 1;//该账号已经存在
        }else{
            $data = [
                'username' => $username,
                'password' => md5($password)
            ];
            $res = Db::table('user')->insert($data);
            if($res){
                echo 2;
            }else{
                echo 3;
            }
        }
    }
    public function change_UserStatus(){
        $model = new UserModel();
        $user_id = $_POST['user_id'];
        $status = $_POST['status'];
        $res = $model->change_user_status($user_id,$status);
        echo $res;
    }
}