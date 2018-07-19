<?php
namespace Admin\Controller;
use Think\Controller;
class AdminController extends CommonController {
  
	//导航栏的 增删改查 搜索分页
	public function adminList(){
		
	 	$numPerPage = empty($_REQUEST["numPerPage"])?"10":$_REQUEST["numPerPage"];
		
		
		$admin = M("admin"); // 实例化User对象
		
		$count      = $admin->count();// 查询满足要求的总记录数
		
		$Page       = new \Think\Page($count,$numPerPage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		
		$list = $admin->limit($Page->firstRow.','.$Page->listRows)->order("id asc")->select();
		
		$this->assign('list',$list);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		
		$this->assign('totalCount',$count);             //总条数
		$this->assign('numPerPage',$Page->listRows);      //每页显示多少条
		$this->assign('pageNumShown',10);    //行显示多少页码
		$currentPage = empty($_REQUEST["pageNum"])?1:$_REQUEST["pageNum"];
		
		$this->assign('currentPage',$currentPage);      //当前是第几页
		//var_dump($list);
		$this->display();
	}
	
	public function adminAdd(){
		$this->display("adminAdd");
	}
	
	public function adminAddEdit(){
		
		$data["username"] = $_POST["username"];
		$data["password"] = $_POST["password"];
		$admin = M("admin")->add($data);
		if($admin){
			$this->success("添加成功");
		}else{
			$this->error($upload->getError());
		}
	}
	
	public function adminDelete(){
		
		$data["id"] = $_GET["uid"];
		$ck = M("admin")->where($data)->find();
		if($ck['quanxian'] == '1'){
			$this->error("超级管理员不可删除！");
		}elseif($ck['username'] == $_SESSION['username']){
			$this->error("自己不可删除自己！");
		}else{
			$admin = M("admin")->where($data)->delete();
			if($admin){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
		}
	}
	
	public function adminEdit(){
		
		$data["id"] = $_GET["uid"];
		$admin = M("admin")->where($data)->select();
		
		$this->assign('list',$admin);// 赋值数据集
		$this->display();
	}
	/* 
	public function adminEditEdit(){
		
		$id = $_POST["id"];
		$ck = M("admin")->where("id = $id")->find();
		if($ck['quanxian'] == '1'){
			$this->error("超级管理员不可修改！");
		}else{
			$data["username"] = empty($_POST["username"])?"":$_POST["username"];
			$data["password"] = empty($_POST["password"])?"":$_POST["password"];
			$admin = M("admin")->where("id=$id")->save($data);
			if($admin){
				$this->success("修改成功");
			}else{
				$this->error("修改失败");
			}
		}
	} */
}