<?php
namespace Admin\Controller;
use Think\Controller;
class DdglController extends CommonController {

	//导航栏的 增删改查 搜索分页
	public function ddgl(){
		
	 	$order_number = empty($_POST["order_number"])?"":$_POST["order_number"];
	 	$numPerPage = empty($_REQUEST["numPerPage"])?"10":$_REQUEST["numPerPage"];
		$data["order_number"] =  array("like", "%".$order_number.'%');
		
		$dd = M("orderinfo"); // 实例化User对象
		
		if(!empty($order_number)){
			$count      = $dd->where($data)->count();// 查询满足要求的总记录数
		}else{
			$count      = $dd->count();// 查询满足要求的总记录数
		}
		$Page       = new \Think\Page($count,$numPerPage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		if(!empty($order_number)){
			$list = $dd->where($data)->limit($Page->firstRow.','.$Page->listRows)->order("create_time desc")->select();
		}else{
			$list = $dd->limit($Page->firstRow.','.$Page->listRows)->order("create_time desc")->select();
		}
		
		foreach($list as $k=>$v){
			
			$v['xiaoji'] = $v['number']*$v['jiage'];
			$list_info[$k] = $v;
			
		}
			
		//var_dump($list);
		
		$this->assign('list',$list_info);// 赋值数据集
		
		
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('order_number',$order_number);
		
		$this->assign('totalCount',$count);             //总条数
		$this->assign('numPerPage',$Page->listRows);      //每页显示多少条
		$this->assign('pageNumShown',10);    //行显示多少页码
		$currentPage = empty($_REQUEST["pageNum"])?1:$_REQUEST["pageNum"];
		
		$this->assign('currentPage',$currentPage);      //当前是第几页
		
		$this->display(); 
	}
	
	
		
	public function ddDelete(){
		
		$data["id"] = $_GET["uid"];
		
		$cp = M("orderinfo")->where($data)->delete();
		if($cp){
			$this->success("删除成功");
		}else{
			$this->error("删除失败");
		}
	}
	
}