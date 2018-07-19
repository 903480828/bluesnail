<?php
namespace Admin\Controller;
use Think\Controller;
class NewsController extends CommonController {
  
	//导航栏的 增删改查 搜索分页
	public function newsList(){
		
	 	$title = empty($_POST["title"])?"":$_POST["title"];
	 	$numPerPage = empty($_REQUEST["numPerPage"])?"10":$_REQUEST["numPerPage"];
		$data["title"] = array("like", "%".$title.'%');
		
		$news = M("news"); // 实例化User对象
		
		if(!empty($title)){
			$count      = $news->where($data)->count();// 查询满足要求的总记录数
		}else{
			$count      = $news->count();// 查询满足要求的总记录数
		}
		$Page       = new \Think\Page($count,$numPerPage);// 实例化分页类 传入总记录数和每页显示的记录数(25)
		$show       = $Page->show();// 分页显示输出
		// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
		if(!empty($title)){
			$list = $news->where($data)->limit($Page->firstRow.','.$Page->listRows)->order("sytj and create_time desc")->select();
		}else{
			$list = $news->limit($Page->firstRow.','.$Page->listRows)->order("sytj and create_time desc")->select();
		}
		
		foreach($list as $k=>$v){
			
			$arr['id'] = $v['p_id'];
			$lists = M("nav")->where($arr)->select();
			
			$v['ss_lm'] = $lists[0]['name'];
			$list_info[$k] = $v;
		}
		
		$this->assign('list',$list_info);// 赋值数据集
		$this->assign('page',$show);// 赋值分页输出
		$this->assign('title',$title);
		
		$this->assign('totalCount',$count);             //总条数
		$this->assign('numPerPage',$Page->listRows);      //每页显示多少条
		$this->assign('pageNumShown',10);    //行显示多少页码
		$currentPage = empty($_REQUEST["pageNum"])?1:$_REQUEST["pageNum"];
		
		$this->assign('currentPage',$currentPage);      //当前是第几页
		
		$this->display();
	}
	
	public function newsAdd(){
		$news = M("nav");
		$list = $news->where("p_id like '0,4,%'")->select();
		$this->assign("list",$list);
		$this->display("newsAdd");
	}
	
	public function newsAddEdit(){
		
		$sytj = $_POST["sytj"];
		$xiangguan = $_POST["xiangguan"];
		$hot = $_POST["hot"];
		
		$data["sytj"] = $sytj;
		$data["xiangguan"] = $xiangguan;
		$data["hot"] = $hot;
		
		$cs = M("news")->add($data);
		
		$tj = M("news")->where("sytj = '$sytj'")->select();
		$xg = M("news")->where("xiangguan = '$xiangguan'")->select();
		$hot = M("news")->where("hot = '$hot'")->select();
		
		$cd1 = count($tj);
		$cd2 = count($xg);
		$cd3 = count($hot);
		if($cd1 == 6){
			
			$data1 = M("news")->where("id = '$cs'")->delete();
			if($data1){
				$this->error("新闻首页推荐位最多只能有五个");
			}
			
			
		}elseif($cd2 == 9){
			
			$data2 = M("news")->where("id = '$cs'")->delete();
			if($data2){
				$this->error("相关新闻位最多只能有八个");
			}
			
			
		}elseif($cd3 == 9){
			
			$data3 = M("news")->where("id = '$cs'")->delete();
			if($data3){
				$this->error("热门推荐位最多只能有八个");
			}
			
		}else{
		
			$time1 = time();
			$time = date("Y-m-d h:i:s",$time1);
			$data["create_time"] = $time;
			$data["name"] = $_POST["name"];
			$data["title"] = $_POST["title"];
			
			$data["zhaiyao"] = $_POST["zhaiyao"];
			
			$data["content"] = $_POST["content"];
			$data["p_id"] = $_POST["p_id"];
			$news = M("news")->add($data);
			
			
			if($news){
				$this->success("添加成功");
			}else{
				$this->error($upload->getError());
			}
		}
	}
		
	public function newsDelete(){
		
		$data["id"] = $_GET["uid"];
		$id = $_GET["uid"];
		$pid = "0,".$id.",";
		$news1 = M("news")->where("p_id like '$pid%'")->select();
		if($news1){
			$this->error("请先清除其下的子栏目");
		}else{
			$news = M("news")->where($data)->delete();
			if($news){
				$this->success("删除成功");
			}else{
				$this->error("删除失败");
			}
		}
	}
	
	public function newsEdit(){
		
		$data["id"] = $_GET["uid"];
		$news = M("news")->where($data)->select();
		foreach($news as $k=>$v){
			
			$arr['id'] = $v['p_id'];
			$lists = M("nav")->where($arr)->select();
			
			$v['ss_lm'] = $lists[0]['name'];
			$list_info[$k] = $v;
			
		}
		
		$this->assign('list',$list_info);// 赋值数据集
		$this->display();
	}
	
	public function newsEditEdit(){
		
		$id = $_POST["id"];
		$sytj = $_POST["sytj"];
		$xiangguan = $_POST["xiangguan"];
		$hot = $_POST["hot"];
		
		$data["sytj"] = empty($sytj)?"":$sytj;
		$data["xiangguan"] = empty($xiangguan)?"":$xiangguan;
		$data["hot"] = empty($hot)?"":$hot;
		$newscx = M("news")->where("id=$id")->save($data);
		$tj = M("news")->where("sytj = '$sytj'")->select();
		$xg = M("news")->where("xiangguan = '$xiangguan'")->select();
		$hot = M("news")->where("hot = '$hot'")->select();
		$cd1 = count($tj);
		$cd2 = count($xg);
		$cd3 = count($hot);
		/* var_dump($cd1);
		var_dump($cd2);
		var_dump($cd3);
		exit; */
		if($cd1 == 6){
			$data1["sytj"] = 0;
			$newstj = M("news")->where("id=$id")->save($data1);
			if($newstj){
				$this->error("新闻首页推荐位最多只能有五个");
			}
			
			
			
		}elseif($cd2 == 9){
			$data2["xiangguan"] = 0;
			$newsxg = M("news")->where("id=$id")->save($data2);
			if($newsxg){
				$this->error("相关新闻位最多只能有八个");
			}
			
			
			
		}elseif($cd3 == 9){
			$data3["hot"] = 0;
			$newshot = M("news")->where("id=$id")->save($data3);
			if($newshot){
				$this->error("热门推荐位最多只能有八个");
			}
			
			
			
		}else{
			
			$time1 = time();
			$time = date("Y-m-d h:i:s",$time1);
			$data["create_time"] = $time;
			$data["name"] = empty($_POST["name"])?"":$_POST["name"];
			$data["title"] = empty($_POST["title"])?"":$_POST["title"];
			$data["zhaiyao"] = empty($_POST["zhaiyao"])?"":$_POST["zhaiyao"];
			
			$data["content"] = empty($_POST["content"])?"":$_POST["content"];
			
			$news = M("news")->where("id=$id")->save($data);
			
			if($news){
				$this->success("修改成功");
			}else{
				$this->error("修改失败");
			}
		}
	}
	
	public function shopingUpdateImg(){
	   
		$reinfo = array('err'=>"",'msg'=>"");
		$upload = new \Think\UploadFile();
		//设置上传文件大小
		$upload->maxSize  = 5120000 ;
		//设置上传文件类型
		$upload->allowExts  = explode(',','txt,rar,zip,jpg,jpeg,pjpeg,gif,png,swf,wmv,avi');
		//设置附件上传目录
		$upload->savePath =  './Public/Uploads/mytmp/';
		$upload->saveRule = uniqid;
		   //删除原图
		   $upload->thumbRemoveOrigin = true;
		   $upload->upload();
			$uploadList = $upload->getUploadFileInfo();
		$reinfo['msg']  =__ROOT__.'/Public/Uploads/mytmp/'.$uploadList[0]['savename'];
		echo json_encode($reinfo);


	}
	
		
}