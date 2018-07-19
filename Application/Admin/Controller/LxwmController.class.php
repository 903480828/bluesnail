<?php
namespace Admin\Controller;
use Think\Controller;
class LxwmController extends CommonController {
	
	public function lxwmList(){
		
		$numPerPage = empty($_REQUEST["numPerPage"])?"10":$_REQUEST["numPerPage"];
		
		$message = M('message'); // 实例化User对象
		
		$count      = $message->count();// 查询满足要求的总记录数
		
		$Page       = new \Think\Page($count,$numPerPage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		
		$list = $message->limit($Page->firstRow.','.$Page->listRows)->order("id asc")->select();
		
		//var_dump($list);
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		
		$this->assign('totalCount',$count);             //总条数
		$this->assign('numPerPage',$Page->listRows);      //每页显示多少条
		$this->assign('page',$Page);
		$this->assign('pageNumShown',10);    //行显示多少页码
		$currentPage = empty($_REQUEST["pageNum"])?1:$_REQUEST["pageNum"];
		
		$this->assign('currentPage',$currentPage);      //当前是第几页
		
		$this->display();
	}
	
	public function lxwmSelect(){
		
		$data["id"] = $_GET["uid"];
		$message = M("message")->where($data)->select();
		$this->assign('list',$message);
		$this->display();
	}
	
	public function lxwmDelete(){
		
		$data["id"] = $_GET["uid"];
		$message = M("message")->where($data)->delete();
		if($message){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
		
		
	}
	
}