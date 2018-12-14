<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Session;
class Order extends Common
{
    //查询未处理的订单
	public function order(){
	    $orderlist = Db::table('order')
            ->alias('a')
            ->join('user b','a.user_id = b.user_id')
            ->join('route c','a.route_id = c.route_id')
            ->where("is_handle",0)
            ->paginate(5);
	    $this->assign('orderlist',$orderlist);
		return view();
	}

	//修改未处理的订单为已处理
	public function ticket_issue(){
	    $id = $_POST['id'];
        $where = "id=$id";
        $res = Db::table('order')->where($where)->update(['is_handle' => '1']);
        if($res){
            echo 0;
        }else{
            echo 1;
        }
    }

	//查看指定一个订单的详细信息
    public function order_details(){
	    $id = $_GET['id'];
	    $where = "id=$id";
        $order_details = Db::table('order')
            ->alias('a')
            ->join('user b','a.user_id = b.user_id')
            ->join('route c','a.route_id = c.route_id')
            ->where($where)
            ->select();
        $this->assign('order_details',$order_details);
        return view();
    }

    //查看此网站从上线到现在所有的订单信息
	public function order_log(){
        $orderlist = Db::table('order')
            ->alias('a')
            ->join('user b','a.user_id = b.user_id')
            ->join('route c','a.route_id = c.route_id')
            ->paginate(5);
        $this->assign('orderlist',$orderlist);
		return view();
	}

	//修改订单的删除状态
    public function order_del_save(){
	    $id = $_POST['id'];
	    $order_del_status = $_POST['order_del_status'];
        $where = "id=$id";
        $res = Db::table('order')->where($where)->update(['order_del_status' => $order_del_status]);
        if($res){
            echo 0;
        }else{
            echo 1;
        }
    }

    public function serach(){
	    $order_number = $_POST['order_number'];
	    $order_list = Db::table('order')
            ->alias('a')
            ->join('user b','a.user_id = b.user_id')
            ->join('route c','a.route_id = c.route_id')
            ->where('order_number','like',"%$order_number%")
            ->select();
	    if($order_list){
            $this->assign('order_list',$order_list);
        }else{
            echo "<script>alert('请输入正确的订单编号');
                    location.href=\"http://www.tours.com/admin/order/order_log.html\"
                    </script>";
        }
        return view();
    }
}