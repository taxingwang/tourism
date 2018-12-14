<?php 
namespace app\index\Model;
use think\Model;
use think\Db;
use think\Session;
use phpmailer\Email;
use think\Paginator;
use think\Cookie;
class LoginModel extends Model{
	//发送邮件
	public function send_email($email,$title,$message){
		$obj = new Email();
        return $res = $obj->send($email,$title,$message);
	}
	//验证用户名/邮箱
	public function get_accounts($data){
		if(empty($data['email'])){
            $res = Db::table("user")->where("username",$data['username'])->find();
            if($res){
            	return 1;
            }else{
                return 0;
            }
        }else{
            $res = Db::table("user")->where("username",$data['username'])->find();
            if($res){
                if($res['email']==$data['email']){
                    return 1;
                }else{
                    return 0;
                }
            }else{
                return 0;
            }
        }
	}
	//注册数据入库
	public function register_do($data){
		$username = trim($data['username']);
	    $str = [
	        'username' => $username,
	        'password' => md5(trim($data['password'])),
	        'tel' => trim($data['tel']),
	        'email' => trim($data['email']),
            'user_status' => 0
        ];
		$userlist = Db::table('user')->where("username",$username)->select();
        if($userlist){
            return 0;//账号已存在
        }else{
            $res = Db::table('user')->insert($str);
            if($res){
                return 1;
            }else{
                return 2;
            }
        }
	}
	public function get_token($username){
		$time = strtotime(date("Ymd His"));
		$str = $username.",".$time;
		$arr = base64_encode($str);
		return $arr;
	}
	public function LoginDo($username,$pwd){
		$password = md5($pwd);
		$res = Db::table("user")->where("username",$username)->find();
		if($res){
			if($res['password']==$password){
				if($res['user_status']==0){
					return 2;
				}else{
					$where = "user_id=".$res['user_id'];
					$update = ["last_time"=>date("Y-m-d H:i:s")];
					Session::set("user_id",$res['user_id']);
					Session::set("username",$res['username']);
					$res = Db::table('user')->where($where)->update($update);
					if($res){
						return 1;
					}else{
						return 0;
					}
				}
			}else{
				return 3;
			}
		}else{
			return 4;
		}
	}
}