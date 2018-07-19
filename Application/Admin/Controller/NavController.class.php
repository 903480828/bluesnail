<?php
namespace Admin\Controller;
use Think\Controller;
class NavController extends CommonController {
  
	//导航栏的 增删改查 搜索分页
	public function navList(){
		
	 	$name = empty($_POST["name"])?"":$_POST["name"];
	 	$numPerPage = empty($_REQUEST["numPerPage"])?"10":$_REQUEST["numPerPage"];
		$data["name"] = array("like", "%".$name.'%');
		
		$nav = M('nav'); // 实例化User对象
		
		if(!empty($name)){
			$count      = $nav->where($data)->count();// 查询满足要求的总记录数
		}else{
			$count      = $nav->count();// 查询满足要求的总记录数
		}
		$Page       = new \Think\Page($count,$numPerPage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		if(!empty($name)){
			$list = $nav->where($data)->limit($Page->firstRow.','.$Page->listRows)->order("concat(p_id,id) asc")->select();
		}else{
			$list = $nav->limit($Page->firstRow.','.$Page->listRows)->order("concat(p_id,id) asc")->select();
		}
		
		foreach($list as $k=>$v){
			
			$pid = explode(',',$v['p_id']);
			$p_id = array_slice($pid,1,1);
			
			if(strlen($p_id[0]) != 0){
				$arr['id'] = $p_id[0];
				$lists = $nav->where($arr)->select();
				/* var_dump($p_id);
				var_dump($lists); */
				$v['ss_lm'] = $lists[0]['name'];
				
			}else{
				
				
				$v['ss_lm'] = '顶级栏目';
			}
			
			$list_info[$k] = $v;
			
		}
		
		$this->assign('list',$list_info);// 赋值数据集
		
		//var_dump($list_info);
		/* $this->assign('lists',$lists);// 赋值数据集 */
		
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('name',$name);
		
		$this->assign('totalCount',$count);             //总条数
		$this->assign('numPerPage',$Page->listRows);      //每页显示多少条
		$this->assign('pageNumShown',10);    //行显示多少页码
		$currentPage = empty($_REQUEST["pageNum"])?1:$_REQUEST["pageNum"];
		
		$this->assign('currentPage',$currentPage);      //当前是第几页
		
		$this->display("navList"); 
	}
	
	public function navAdd(){ 
		$nav = M('nav');
		$list = $nav->where("p_id='0,'")->select();
		$this->assign("list",$list);
		
		$this->display();
	}
	public function navAddEdit(){
		
		
		
		$data["name"] = $_POST["name"];
		$data["type"] = $_POST["type"];
		
		
		$p_id1 = $_POST["p_id"];
		
		if($p_id1 == '0,'){
			$data["p_id"] = $p_id1;
			$nav = M("nav")->add($data);
			if($nav){
			$this->success("添加成功");
			}else{
				$this->error("添加失败");
			}
		}elseif($p_id1 == '2'){
			$nav = M("nav")->add($data);
			$datap["name"] = $_POST["name"];
			$datap["title"] = $_POST["name"];
			$datap["type"] = 1;
			
			$datap["p_id"] = $nav;
			$pp = M("pinpai")->add($datap);
			if($nav){
				$p_id = "0,".$p_id1.",".$nav.",";
				$data1["p_id"] = $p_id;
				$nav1 = M("nav")->where("id=$nav")->save($data1);
				if($nav1){
				$this->success("添加成功");
				}else{
					$this->error("添加失败");
				}
			}else{
				$this->error("添加失败");
			}
		}else{
			$nav = M("nav")->add($data);
			var_dump($nav);
				exit;
			if($nav){
				$p_id = "0,".$p_id1.",".$nav.",";
				$data1["p_id"] = $p_id;
				
				$nav1 = M("nav")->where("id=$nav")->save($data1);
				
				if($nav1){
				$this->success("添加成功");
				}else{
					$this->error("添加失败");
				}
			}else{
				$this->error("添加失败");
			}
		}
	}
		
	public function navDelete(){
		
		$data["id"] = $_GET["uid"];
		$datap["p_id"] = $_GET["uid"];
		$id = $_GET["uid"];
		$pid = "0,".$id.",";
		
		$nav1 = M("nav")->where("p_id like '$pid%'")->select();
		if($nav1){
			$this->error("请先清除其下的子栏目");
		}else{
			$nav = M("nav")->where($data)->delete();
			$pp = M("pinpai")->where($datap)->delete();
			
			if($nav && $pp){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
		}
	}
	
	public function navEdit(){
		
		$data["id"] = $_GET["uid"];
		$nav = M("nav")->where($data)->select();
		foreach($nav as $k=>$v){
			
			$pid = explode(',',$v['p_id']);
			$p_id = array_slice($pid,1,1);
			
			if(strlen($p_id[0]) != 0){
				$arr['id'] = $p_id[0];
				$lists = M("nav")->where($arr)->select();
				/* var_dump($p_id);
				var_dump($lists); */
				$v['ss_lm'] = $lists[0]['name'];
				
			}else{
				
				
				$v['ss_lm'] = '顶级栏目';
			}
			
			$list_info[$k] = $v;
			
		}
		
		$this->assign('list',$list_info);// 赋值数据集
		$this->display();
	}
	
	public function navEditEdit(){
		$id = $_POST["id"];
		$data["name"] = $_POST["name"];
		$data["type"] = $_POST["type"];
		
		$datap["name"] = $_POST["name"];
		$datap["title"] = $_POST["name"];
		
		
		
		$nav = M("nav")->where("id = $id")->save($data);
		$pp = M("pinpai")->where("p_id = $id")->save($datap);
		
		if($nav && $pp){
			$this->success("修改成功");
		}else{
			$this->error("修改失败");
		}
		
	}
	
		
}