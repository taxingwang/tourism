<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Session;
use think\Paginator;
use think\Cookie;
use app\index\Model\OrderModel;
class Order extends Controller
{
    public function order_list(){
        if(empty(Session::get("username"))){
            echo '<script>alert("您还没有登录，请先登录");location.href="http://www.tours.com/index/login/login"</script>';
        }else{

            $username = Session::get("username");
            $this->assign("username",$username);
            $user_id = Session::get('user_id');
            $data = Db::table("order")->alias("o")->join("route r","o.route_id=r.route_id")->join("order_detail od","o.id=od.order_id")->where("user_id",$user_id)->where("order_status",0)->paginate(5);
            // echo "<pre>";
            // print_r($data);
            $this->assign("data",$data);
            return view();
        }
    }
    public function order_lists(){
            $username = Session::get("username");
            $this->assign("username",$username);
            $user_id = Session::get('user_id');
            $data = Db::table("order")->alias("o")->join("route r","o.route_id=r.route_id")->join("order_detail od","o.id=od.order_id")->where("user_id",$user_id)->where("order_status",1)->paginate(5);
            $this->assign("data",$data);
            return view();
    }
    //用户下单之前判断用户是否登录、用户生成的订单入库
    public function order(){
        $model = new OrderModel();
        if(empty(Session::get("username"))){
            echo 0; //判断是否登录 如果未登录则返回去登录
        }else{
            $user_id = Session::get('user_id');
            //由TR开头+当前的时间戳+user_id+6位随机数生成唯一订单号
            $order_number = 'TR'.strtotime(date("YmdHis")).$user_id.rand(100000,999999);
            $price = $_POST['money'];
            $num = $_POST['num'];
            $get_order_name = Db::table("route")->where("route_id",$_POST['route_id'])->find();
            $order_name = $get_order_name['route_name'];
            $money = $price*$num; //计算出一共几张票的总价
            $data = [
                'order_number' => $order_number,
                'user_id' => $user_id,
                'route_id'=> $_POST['route_id'],
                'order_time' =>date("Y-m-d H:i:s"),
                'order_status' => 0,
                'order_money'=> $money,
                'order_del_status' => 0,
                'is_handle' => 0,
                'order_name'=>$order_name
            ];
            Cookie::set('order_number',$order_number);
            $res = $model->orders('order',$data);
            $order_id = Db::name('order')->getLastInsID();
            $detail = [
                'order_id' => $order_id,
                'price' => $price,
                'num' => $num
            ];
            $model->orders('order_detail',$detail);
            if($res){
                echo 1;
            }else{
                echo 2;
            }
        }
    }
    //用户确认订单并进行支付
    public function is_order(){
        $model = new OrderModel();
        $order_number = empty($_GET['order_number'])?Cookie::get('order_number'):$_GET['order_number'];
        $username = Session::get("username");
        $this->assign("username",$username);
        $order = $model->is_order('order',$order_number);
        $this->assign('order',$order);
        return view();
    }
    public function pay_return(){
        $order_number = $_GET['out_trade_no'];
        $update = ["order_status"=>1];
        $res = Db::table("order")->where("order_number",$order_number)->update($update);
        if($res){
            echo '<script>alert("商家已收到您的付款，稍后为您出票");location.href="http://www.tours.com/index/Order/order_lists"</script>';
        }else{
            echo '<script>alert("系统繁忙...");location.href="http://www.tours.com/index/Order/order_lists"</script>';
        }
    }
}
