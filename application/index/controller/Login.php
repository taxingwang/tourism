<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use phpmailer\Email;
use think\Session;
use think\Cookie;
use app\Index\Model\LoginModel;
class Login extends Controller
{
	//登录页面
	public function login(){
        
		return view();
	}
    //验证码
    public function show_captcha(){  
        $captcha = new \think\captcha\Captcha();  
        $captcha->imageW=121;  
        $captcha->imageH = 32;  //图片高  
        $captcha->fontSize =14;  //字体大小  
        $captcha->length   = 4;  //字符数  
        $captcha->fontttf = '5.ttf';  //字体  
        $captcha->expire = 30;  //有效期  
        $captcha->useNoise = false;  //不添加杂点  
        return $captcha->entry();  
    }
    //验证码验证
    public function cptcha_check(){
        $code=$_POST['code'];
        $captcha = new \think\captcha\Captcha();
        $result=$captcha->check($code);
        if($result===false){
            echo 0;
        }else{
            echo 1;
        }
    } 
	//验证用户名密码登录
    public function login_do(){
        $model = new LoginModel();
	    $username = $_POST['username'];
        $password = $_POST['password'];
        $res = $model->LoginDo($username,$password);
        echo $res;
    }
    //用户账号激活(发送QQ邮件)
    public function activation(){
        return view();
    }
    //验证用户名/邮箱的正确
    public function GetAccounts(){
        $model = new LoginModel();
        $data = $_POST;
        $res = $model->get_accounts($data);
        echo $res;
    }
    //发送邮件
    public function SendEmail(){
        $model = new LoginModel();
        $email = $_POST['email'];
        $username = $_POST['username'];
        if(Cookie::has("username")){
            $user = Cookie::get("username");
            if($user==$username){
                echo 3;
            }else{
                $res = Db::table("user")->where("username",$username)->find();
                if($res['user_status']==1){
                    echo 4;
                }else{
                    $str = $model->get_token($username);
                    $message = "http://www.tours.com/index/login/activation_do?str=$str";
                    $title = '“旅行者”账号激活';
                    $res = $model->send_email($email,$title,$message);
                    Cookie::set("username",$username,300);
                    echo $res;
                }
            }
        }else{
            $res = Db::table("user")->where("username",$username)->find();
                if($res['user_status']==1){
                    echo 4;
                }else{
                    $str = $model->get_token($username);
                    $message = "http://www.tours.com/index/login/activation_do?str=$str";
                    $title = '“旅行者”账号激活';
                    $res = $model->send_email($email,$title,$message);
                    Cookie::set("username",$username,300);
                    echo $res;
                }
        }
        
    }
    public function activation_do(){
        $data = $_GET['str'];
        $data = base64_decode($data);
        $arr = explode(",",$data);
        if(strtotime(date("Ymd His"))-$arr[1]<300){
            $update = ["user_status"=>1];
            $res = Db::table("user")->where("username",$arr[0])->update($update);
            if($res){
                echo '<script>alert("帐号已激活，前往登录");location.href="http://www.tours.com/index/login/login"</script>';
            }else{
                echo '<script>alert("激活失败，请重新发送邮件进行激活");location.href="http://www.tours.com/index/login/activation"</script>';
            }
        }else{
            echo '<script>alert("token有效时间已过，请重新发送邮件进行激活");location.href="http://www.tours.com/index/login/activation"</script>';
        }
    }
	//注册页面
    public function register(){
        return view();
    }

    //注册操作
    public function registers(){
	    $model = new LoginModel();
        $data = $_POST;
        $res = $model->register_do($data);
        echo $res;
    }
    
}