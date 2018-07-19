<?php
namespace Admin\Controller;
use Think\Controller;
class pinpaiController extends CommonController {
	
	//导航栏的 增删改查 搜索分页
	public function ppSelect(){
		$id = $_GET["id"];
		$nav = M("nav")->where("id = '$id'")->select();
		$pp = M("pinpai")->where("p_id = '$id'")->select();
		//var_dump($pp);
		$this->assign("nav",$nav);
		$this->assign("list",$pp);
		$this->display();
	}
	
	public function ppUpdate(){
		$tj = M("pinpai")->where("sytj = 1")->select();
		$id = $_POST["id"];
		$data["sytj"] = $_POST["sytj"];
		$data["type"] = $_POST["type"];
		$data["content"] = $_POST["content"];
		
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     0 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/'; // 设置附件上传根目录
		$upload->savePath  =     '/baby/images/upload/'; // 设置附件上传（子）目录
		// 上传文件 
		$info   =   $upload->upload();
		
		$pinpai = M('pinpai')->field('thumb')->where("username = '$username'")->find();
		
		if($pinpai['thumb'] != ""){
			$filename = 'Public'.$pinpai['thumb'];
			unlink($filename);
		}
		
		if(!empty($info)){
			$thumb = $info['thumb']['savepath'].$info['thumb']['savename'];
			$data["thumb"] = $thumb;
		}
		
		if($tj){
			foreach($tj as $k=>$v){
				$syid = $v["id"];
			}
			
			if($id == $syid){
				
				//var_dump($_POST["sytj"]);
				//exit;
				
				if($_POST["sytj"] == '0'){
					
					$this->error("首页品牌推荐不能为空");
					
				}else{
					$pp = M("pinpai")->where("id = '$id'")->save($data);
					if($pp){
						$this->success("修改成功");
					}else{
						$this->error("修改失败");
					}
				}
				
			}else{
				
				if($_POST["sytj"] == '1'){
					
					$data1["sytj"] = 0;
					$pp1 = M("pinpai")->where("id = '$syid'")->save($data1);
					
				}
				
				$pp = M("pinpai")->where("id = '$id'")->save($data);
				if($pp){
					$this->success("修改成功");
				}else{
					$this->error("修改失败");
				}
			}
		}else{
			$pp = M("pinpai")->where("id = '$id'")->save($data);
			if($pp){
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
		$upload->thumbbRemoveOrigin = true;
		$upload->upload();
		$uploadList = $upload->getUploadFileInfo();
		$reinfo['msg']  =__ROOT__.'/Public/Uploads/mytmp/'.$uploadList[0]['savename'];
		echo json_encode($reinfo);

	}

	
}