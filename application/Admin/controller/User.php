<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
class User extends Common
{
    //前台用户列表
   public function userlist(){
       $userlist = Db::table('user')->order('user_id asc')->paginate(5);;

       $this->assign('userlist',$userlist);
       return view();
   }
}