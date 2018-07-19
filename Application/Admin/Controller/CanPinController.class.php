<?php
namespace Admin\Controller;
use Think\Controller;
class CanPinController extends CommonController {

	//导航栏的 增删改查 搜索分页
	public function cpList(){
		
	 	$title = empty($_POST["title"])?"":$_POST["title"];
	 	$numPerPage = empty($_REQUEST["numPerPage"])?"10":$_REQUEST["numPerPage"];
		$data["title"] =  array("like", "%".$title.'%');
		
		$cp = M("fenlei"); // 实例化User对象
		
		if(!empty($title)){
			$count      = $cp->where($data)->count();// 查询满足要求的总记录数
		}else{
			$count      = $cp->count();// 查询满足要求的总记录数
		}
		$Page       = new \Think\Page($count,$numPerPage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		if(!empty($title)){
			$list = $cp->where($data)->limit($Page->firstRow.','.$Page->listRows)->order("sytj and create_time desc")->select();
		}else{
			$list = $cp->limit($Page->firstRow.','.$Page->listRows)->order("sytj and create_time desc")->select();
		}
		
		foreach($list as $k=>$v){
			
			$arr['id'] = $v['p_id'];
			$lists = M("nav")->where($arr)->select();
			
			$v['ss_lm'] = $lists[0]['name'];
			$list_info[$k] = $v;
			
		}
			
		
		
		$this->assign('list',$list_info);// 赋值数据集
		
		//var_dump($list_info);
		/* $this->assign('lists',$lists);// 赋值数据集 */
		
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('title',$title);
		
		$this->assign('totalCount',$count);             //总条数
		$this->assign('numPerPage',$Page->listRows);      //每页显示多少条
		$this->assign('pageNumShown',10);    //行显示多少页码
		$currentPage = empty($_REQUEST["pageNum"])?1:$_REQUEST["pageNum"];
		
		$this->assign('currentPage',$currentPage);      //当前是第几页
		
		$this->display(); 
	}
	
	public function cpAdd(){
		$cp = M("nav");
		$list = $cp->where("p_id like '0,3,%'")->select();
		$this->assign("list",$list);
		$this->display();
	}
	
	public function cpAddEdit(){
		
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     0 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/'; // 设置附件上传根目录
		$upload->savePath  =     '/baby/images/upload/'; // 设置附件上传（子）目录
		// 上传文件 
		$info   =   $upload->upload();
		
		if(!empty($info)){
			$thumb = $info['thumb']['savepath'].$info['thumb']['savename'];
			$data["thumb"] = $thumb;
		}
		
		$data["title"] = $_POST["title"];
		$data["type"] = $_POST["type"];
		$data["jiage"] = $_POST["jiage"];
		$data["sytj"] = $_POST["sytj"];
		$data["rongliang"] = $_POST["rongliang"];
		$data["gongxiao"] = $_POST["gongxiao"];
		$data["jianjie"] = $_POST["jianjie"];
		$data["content"] = $_POST["content"];
		$data["p_id"] = $_POST["p_id"];
		$cp = M("fenlei")->add($data);
		
		
		if($cp){
			$this->success("添加成功");
		}else{
			$this->error($upload->getError());
		}
	}
		
	public function cpDelete(){
		
		$data["id"] = $_GET["uid"];
		$id = $_GET["uid"];
		$pid = "0,".$id.",";
		$cp1 = M("fenlei")->where("p_id like '$pid%'")->select();
		if($cp1){
			$this->error("请先清除其下的子栏目");
		}else{
			$cp = M("fenlei")->where($data)->delete();
			if($cp){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
		}
	}
	
	public function cpEdit(){
		
		$data["id"] = $_GET["uid"];
		$cp = M("fenlei")->where($data)->select();
		foreach($cp as $k=>$v){
			
			$arr['id'] = $v['p_id'];
			$lists = M("nav")->where($arr)->select();
			
			$v['ss_lm'] = $lists[0]['name'];
			$list_info[$k] = $v;
			
		}
		
		$this->assign('list',$list_info);// 赋值数据集
		$this->display();
	}
	
	public function cpEditEdit(){
		$id = $_POST["id"];
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     0 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/'; // 设置附件上传根目录
		$upload->savePath  =     '/baby/images/upload/'; // 设置附件上传（子）目录
		// 上传文件 
		$info   =   $upload->upload();
		
		
		$canpin = M('fenlei')->field('thumb')->where("username = '$username'")->find();
		
		if($canpin['thumb'] != ""){
			$filename = 'Public'.$canpin['thumb'];
			unlink($filename);
		}
		
		$data["title"] = empty($_POST["title"])?"":$_POST["title"];
		$data["sytj"] = empty($_POST["sytj"])?"":$_POST["sytj"];
		$data["type"] = empty($_POST["type"])?"":$_POST["type"];
		$data["jiage"] = empty($_POST["jiage"])?"":$_POST["jiage"];
		if(!empty($info)){
			$thumb = $info['thumb']['savepath'].$info['thumb']['savename'];
			$data["thumb"] = $thumb;
		}
		$data["rongliang"] = empty($_POST["rongliang"])?"":$_POST["rongliang"];
		$data["gongxiao"] = empty($_POST["gongxiao"])?"":$_POST["gongxiao"];
		$data["jianjie"] = empty($_POST["jianjie"])?"":$_POST["jianjie"];
		$data["content"] = empty($_POST["content"])?"":$_POST["content"];
		
		$cp = M("fenlei")->where("id=$id")->save($data);
		
		if($cp){
			$this->success("修改成功");
		}else{
			$this->error("修改失败");
		}
		
	}
	
		
}