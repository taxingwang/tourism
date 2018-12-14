<?php
namespace app\admin\controller;
use think\Controller;
use think\Db;
use think\Session;
use think\File;
use think\Paginator;
class News extends Common
{
    //查询未删除的新闻
	public function news_list(){
        $list = Db::name('news')->order('new_time desc')->where('new_status',0)->paginate(5);
        $this->assign('list',$list);
        return view();
    }
    //修改字段删除新闻
    public function news_save(){
        $id = $_POST['id'];
        $res = Db::table('news')->where('new_id',$id)->update(['new_status' => '1']);
        if($res){
            echo 0;
        }else{
            echo 1;
        }
    }
    //发布新闻
    public function news_add(){
        if($_POST){
            $file = request()->file('new_img');
            $new_img = $this->upload($file);
            $data = [
                'new_title' => $_POST['new_title'],
                'new_img' => $new_img,
                'new_desc' => $_POST['new_desc'],
                'new_content' => $_POST['new_content'],
                'new_time' => date("Y-m-d H:i:s"),
                'new_status' => 0,
                'new_click' => 0,
            ];
            $res = Db::table('news')->insert($data);
            if($res){
                $this->success('发布成功','News/news_list',2);
            }else{
                $this->error('出错了！！！',2);
            }
        }else{
            return view();
        }
    }
    //文件上传
    public function upload($file){
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file){
            $info = $file->move(ROOT_PATH . 'public'. DS . 'admin');
            if($info){
                // 成功上传后 获取上传信息
                return $info->getSaveName();
            }else{
                // 上传失败获取错误信息
                return $file->getError();
            }
        }
    }
}