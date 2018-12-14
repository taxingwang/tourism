<?php 
namespace app\index\Model;
use think\Model;
use think\Db;
use think\Session;
use phpmailer\Email;
use think\Paginator;
use think\Cookie;
class OrderModel extends Model{
    //用户生成订单并进行入库
    public function orders($table,$data){
        $res = Db::table($table)->insert($data);
        return $res;
    }
    //获取这个用户刚入库的订单信息
    public function is_order($table,$order_number){
        $data = Db::table($table)->alias('a')->join('route b','a.route_id = b.route_id')->join('order_detail c','a.id = c.order_id')->where('order_number',$order_number)->find();
        return $data;
    }
}