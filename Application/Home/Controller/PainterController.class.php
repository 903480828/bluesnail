<?php
namespace Home\Controller;
use Think\Controller;
class PainterController extends CommonController {
	//达人页面  画师页面
    public function index(){
		parent::index();
		$ban = M('banner') -> select();
		
		$this -> assign('ban',$ban);
		$this -> display('index');
	}
	//达人 画师 ajax 数据渲染
	public function loads(){
		
		$num = $_POST['num'];
		$id = $_POST['id'];
		if($id != 0){
			$users = M('user') -> where("id != $id") -> order("createtime desc") -> limit($num,8) -> select();
		}else{
			$users = M('user') -> order("createtime desc") -> limit($num,8) -> select();
		}
		$data3 = M('likework') -> where($da) -> field('userid') -> select();
		
		$work = [];
		//var_dump($users);
		foreach($users as $k => $v){
			$work[$k] = $v;
			$lab = explode(',',$v['gxlabel']);
			$labs = '';
			
			$da['follow_id'] = $id;
			$data3 = M('follow') -> where($da) -> select();
			
			for($i=0; $i<sizeof($data3); $i++){
				if($data3[$i]['userid'] == $v['id']){
					$work[$k]['follows'] = 1;
				}
			}
			
			
			for($i=0; $i<sizeof($lab); $i++){
				$work[$k]['lab'] .= '<span>'.$lab[$i].'</span>';
			}
			$works = explode(',',$v['works']);//把字符串用','分割成数组
			for($i=0; $i<2; $i++){
				$data['id'] = $works[$i];
				$w = M('works') -> field('id,thum') -> where($data) -> select();
				$work[$k]['urls'.$i] = $w[0];
			}
		}
		
		$this->ajaxReturn($work);
		
	}
	//个人作品 作者信息	页面渲染 
	public function personal(){
		parent::index();
		$mp = empty($_GET['mp'])?0:$_GET['mp'];
		$id = $_GET['authorid'];
		$data['id'] = $id;
		//var_dump();
		if($_COOKIE['id'] != null){
			$res['follow_id'] = $_COOKIE['id'];
			$res['userid'] = $id;
			$folw = M('follow') -> where($res) -> select();
		}
		$users = M('user') -> where($data) -> select();
		$address = M('province') -> select();
		$work = [];
		$labels = M('label');
		foreach($users as $k => $v){
			$work[$k] = $v;
			$lab = explode(',',$v['gxlabel']);
			
			for($i=0; $i<sizeof($lab); $i++){
				$gx['id'] = $lab[$i];
				$gxdata = $labels -> where($gx) -> field('label,id') -> select();
				
				$work[$k]['gxlab'][$i] = $gxdata[0]['label'];
				$work[$k]['gx'][$i] = $gxdata[0]['id'];
			}
			$old['id'] = $v['oldlabel'];
			$olddata = $labels -> where($old) -> field('label') -> select();
			
			$sf['id'] = $v['sflabel'];
			$sfdata = $labels -> where($sf) -> field('label') -> select();
			
			$work[$k]['oldlab'] = $olddata[0]['label'];
			$work[$k]['sflab'] = $sfdata[0]['label'];
			$add['id'] = $v['address'];
			$ad = M('province') -> where($add) -> field('address') -> select();
			//var_dump($work[$k]['gxlab']);
		}
		
		$work[0]['add'] = $ad[0]['address'];
		
		if($folw){
			$this -> assign('follows','已关注');
		}else{
			$this -> assign('follows','关注');
		}
		
		$sflabel = M('label') -> where("type = 'sflabel'") -> select();
		$oldlabel = M('label') -> where("type = 'oldlabel'") -> select();
		$gxlabel = M('label') -> where("type = 'gxlabel'") -> select();
		
		$this -> assign('mp',$mp);
		$this -> assign('users',$work[0]);
		$this -> assign('name','namess');
		$this -> assign('addr',$address);
		$this -> assign('sflabel',$sflabel);
		$this -> assign('oldlabel',$oldlabel);
		$this -> assign('gxlabel',$gxlabel);
		
		$this -> display('personal');

	}
	//个人作品ajax数据请求渲染
	public function personallist(){
		
		$num = $_POST['num'];
		$data['author'] = $_REQUEST['authorid'];
		$works = M('works') -> where($data) -> field('id,thum,label,title,createtime,author') -> order("createtime desc") -> limit($num,8) -> select();
		$users = M('user') -> field('id,name,thum') -> select();
		$work = [];
		foreach($works as $k => $v){
			$work[$k] = $v;
			$lab = explode(',',$v['label']);
			for($i=0; $i<sizeof($lab); $i++){
				$work[$k]['lab'] .= '<span>'.$lab[$i].'</span>';
			}
			$work[$k]['times'] = date("Y/m/d",strtotime($v['createtime']));
		}

		$this->ajaxReturn($work);
		
	}
	
	//作品详情页
	public function details(){
		parent::index();
		//header("Content-Type: text/html;charset=utf-8");
		$mp = empty($_GET['mp'])?0:$_GET['mp'];
		
		$aut = $_GET['authorid'];
		$id = $_GET['imgid'];
		$data['id'] = $aut;
		$imgs['id'] = $id;
		$img2['author'] = $aut;
		if($_COOKIE['id'] != null){
			$res['follow_id'] = $_COOKIE['id'];
			$res['userid'] = $id;
			$folw = M('follow') -> where($res) -> select();
		}
		//用户表
		$users = M('user') -> where($data) -> select();
		//省份
		$address = M('province') -> select();
		//作品详情表
		$imgs = M('works') -> where($imgs) -> select();
		//其他作品
		$xgimg = M('works') -> where("author = $aut and id != $id") -> field('id,thum,author') -> select();
		$work = [];
		$img = [];
		
		foreach($users as $k => $v){
			$work[$k] = $v;
			$lab = explode(',',$v['gxlabel']);
			for($i=0; $i<sizeof($lab); $i++){
				$work[$k]['gxlab'] .= '<span>'.$lab[$i].'</span>';
				$work[$k]['gx'][$i] .= $lab[$i];
			}
			$work[$k]['oldlab'] = '<span>'.$v['oldlabel'].'</span>';
			$work[$k]['sflab'] = '<span>'.$v['sflabel'].'</span>';
		}
		$add = $work[0]['address'];
		$work[0]['add'] = $address[$add]['address'];
		
		foreach($imgs as $k => $v){
			$img[$k] = $v;
			$lab1 = explode(',',$v['images']);
			for($i=0; $i<sizeof($lab1); $i++){
				$img[$k]['img'][$i] = $lab1[$i];
			}
			$lab2 = explode(',',$v['label']);
			for($i=0; $i<sizeof($lab2); $i++){
				$img[$k]['lab'] .= '<span>'.$lab2[$i].'</span>';
			}
			$rig['id'] = $v['right'];
			$right = M('right') -> where($rig) -> select();
			$img[$k]['rinfo'] = $right[0]['info'];
			$img[$k]['right'] = $right[0]['right'];
			$img[$k]['rthum'] = $right[0]['thum'];
		}
		
		if(!empty($_COOKIE["id"])){
			$uid = empty($_COOKIE["id"])?0:$_COOKIE["id"];
			$lik['userid'] = $uid;
			$lik['imgid'] = $id;
			//登录用户是否喜欢
			$likes = M('likework') -> where($lik) -> select();
			if($likes){
				$this -> assign('on','on');
			}else{
				$this -> assign('on','');
			}
		}else{
			$this -> assign('on','');
		}
		if($folw){
			$this -> assign('follows','已关注');
		}else{
			$this -> assign('follows','关注');
		}
		//var_dump($img);
		$this -> assign('mp',$mp);
		$this -> assign('users',$work[0]);
		$this -> assign('name','namess');
		$this -> assign('addr',$address);
		$this -> assign('imgs',$img[0]);
		$this -> assign('xgimg',$xgimg);
		// $this -> assign('com',$com);
		// $this -> assign('len',$len);
		$this -> assign('id',$id);
		$this -> assign('author',$aut);
		
		$this -> display('details');
		
	}
	
	public function commentlise(){
		
		//用户评论
		$con['imgid'] = $_POST['id'];
		$num = $_POST['num'];
		$comment = M('comment') -> where($con) -> limit($num,10) -> order('createtime desc') -> select();
		$len = sizeof($comment);
		$com = [];
		foreach($comment as $k => $v){
			$com[$k] = $v;
			$rep1['comment_id'] = $v['id'];//查询回复表中comment_id 等于  评论表中 id 的数据
			$data1 = M('reply') -> where($rep1) -> order('create_time asc') -> select();
			for($i=0; $i<sizeof($data1); $i++){
				$com[$k]['reply'][$i] = $data1[$i];
				$len++;
				$rep2['id'] = $data1[$i]['userid'];//查询用户表中id 等于  回复表中 userid 的数据
				$data2 = M('user') -> where($rep2) -> select();
				if(!empty($data2)){
					for($j=0; $j<sizeof($data2); $j++){
						$com[$k]['reply'][$i]['author'] = $data2[$j]['name'];
						$com[$k]['reply'][$i]['author_id'] = $data2[$j]['id'];
						$com[$k]['reply'][$i]['author_thum'] = $data2[$j]['thum'];
						$tim1 = strtotime($data2[$j]['createtime']);
						$com[$k]['reply'][$i]['create'] = date('Y-m-d H:i', $tim1);
						
						if($data1[$i]['reply_type'] == 2){
							$reps['id'] = $data1[$i]['to_uid'];
							$datas = M('user') -> where($reps) ->field('name') -> select();
							$com[$k]['reply'][$i]['reply_name'] = $datas[0]['name'];
						}
					}
				}
			}
			
			$rep3['id'] = $v['userid'];//查询用户表中id 等于  评论表中 userid 的数据
			$data3 = M('user') -> where($rep3) ->field('id,thum,name,createtime') -> select();
			$com[$k]['author'] = $data3[0]['name'];
			$com[$k]['author_id'] = $data3[0]['id'];
			$com[$k]['author_thum'] = $data3[0]['thum'];
			$tim2 = strtotime($data3[0]['createtime']);
			$com[$k]['create'] = date('Y-m-d H:i', $tim2);
		}
		//var_dump($com);
		$this->ajaxReturn($com);
	}
	
	public function comment(){
		$data['imgid'] = empty($_POST['imgid'])?$_REQUEST['imgid']:$_POST['imgid'];	//作品id
		$data['author'] = empty($_POST['author'])?$_REQUEST['author']:$_POST['author'];	//作者id
		$data['content'] = empty($_POST['value'])?'':$_POST['value'];					//评论内容
		$data['userid'] = empty($_POST['userid'])?$_REQUEST['userid']:$_POST['userid'];	//评论人id
		$data['createtime'] = date('Y-m-d H:i:s',time());	//评论时间
		$data['topic_type'] = empty($_POST['topic_type'])?1:$_POST['topic_type'];;	//作品类型默认为 1 图片
		$com = M('comment') -> add($data);

		if(!empty($com)){
			$this->ajaxReturn(1);
			
		}else{
			$this->ajaxReturn(0);
		}
	}
	
	public function reply(){
		$data['comment_id'] = empty($_POST['comment_id'])?$_REQUEST['comment_id']:$_POST['comment_id'];	//评论id 或 回复id
		$data['reply_id'] = empty($_POST['reply_id'])?$_REQUEST['reply_id']:$_POST['reply_id'];					//评论内容
		$data['content'] = empty($_POST['value'])?$_REQUEST['value']:$_POST['value'];					//评论内容
		$data['reply_type'] = empty($_POST['reply_type'])?$_REQUEST['reply_type']:$_POST['reply_type'];	//回复属性 1为回复评论 2为回复 回复
		$data['userid'] = empty($_POST['userid'])?$_REQUEST['userid']:$_POST['userid'];	// 回复者id
		$data['to_uid'] = empty($_POST['to_uid'])?$_REQUEST['to_uid']:$_POST['to_uid'];	// 回复者id
		$data['create_time'] = date('Y-m-d H:i:s',time());	//回复时间

		$com = M('reply') -> add($data);
		
		//$this->ajaxReturn($data);
		
		if(!empty($com)){
			$this -> ajaxReturn(1);
			
		}else{
			$this -> ajaxReturn(0);
		}
	}
	
	public function dynamic(){
		parent::index();
		$username = cookie('username');
		$id = cookie('id');
		if(empty($id) || empty($username)){
			echo'<script language="javascript">window.location.href="'.U("Home/User/index").'";</script>';
		}else{
			$rep['userid'] = $id;
			
			$label = M('label') -> where("type = 'gxlabel'") -> order('nummber desc') -> field('label') -> limit(0,5) -> select();
			$right = M('right') -> select();
			//var_dump($right);
			$follow = M('follow') -> where($rep) -> count();
			$likework = M('likework') -> where($rep) -> count();
			//$data2 = M('tuijian') -> where($rep) -> field('imgid') -> select();
			$this -> assign('follow',$follow);
			$this -> assign('like',$likework);
			$this -> assign('label',$label);
			$this -> assign('right',$right);
			$this -> assign('id',$id);
			$this -> display('dynamic');
		}
	}
	
	public function dynamiclist(){
		
		$num = $_POST['num'];
		$id = $_POST['id'];
		$rep['userid'] = $id;
		$data1 = M('follow') -> where($rep) -> field('follow_id') -> select();
		
		$follow = M('follow') -> where($rep) -> count();
		
		foreach($data1 as $k => $v){
			$str1 .= $v['follow_id'].',';
		}
		$str1 = trim($str1,',');
		$data2 = M('tuijian') -> where("userid in ($str1)") -> field('imgid') -> select();//查找登录所用户所关注的人推荐的作品id
		
		foreach($data2 as $k => $v){
			$str2 .= $v['imgid'].',';
		}
		
		$str2 = trim($str2,',');
		
		$type = $_POST['type'];
		
		if($type == 'likes'){
			$lk['userid'] = $id;
			$lks = M('likework') -> where($lk) -> field('imgid') -> select();
			foreach($lks as $k => $v){
				$lkstr .= $v['imgid'].',';
			}
			$lkstr = trim($lkstr,',');
			$works = M('works') -> where("id in ($lkstr)") -> order("createtime desc") -> limit($num,8) -> select();
		}else{
			$works = M('works') -> where("author in ($str1) or id in ($str2)") -> order("createtime desc") -> limit($num,8) -> select();
		}
		//var_dump($lkstr);
		$users = M('user') -> field('id,name,thum') -> select();
		
		$work = [];
		foreach($works as $k => $v){
			$work[$k] = $v;
			$lab = explode(',',$v['label']);
			$labs = '';
			$da['imgid'] = $v['id'];
			$data3 = M('likework') -> where($da) -> field('userid') -> select();
			$reg = '/'.$v['id'].'/';
			if(preg_match($reg,$str2) == 1){
				//通过正则 查找id 是否是关注的人所推荐的作品
				$work[$k]['tuijian'] = 1;
			}
			if($data3[0]['userid'] == $id){
				$work[$k]['likess'] = 1;
			}
			for($i=0; $i<sizeof($lab); $i++){
				$work[$k]['lab'] .= '<span>'.$lab[$i].'</span>';
			}
			for($j=0; $j<sizeof($users); $j++){
				if($works[$k]['author'] == $users[$j]['id']){
					$work[$k]['zz'] = $users[$j]['name'];
					$work[$k]['tx'] = $users[$j]['thum'];
				}
			}
		}
		
		$this->ajaxReturn($work);
		
	}
	
	public function imgfile(){
		
		$id = $_COOKIE['id'];
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/'; // 设置附件上传根目录
		$upload->savePath  =     '/bluesnail/public/upload/'; // 设置附件上传（子）目录
		// 上传文件 
		$info   =   $upload->upload();
		
		if(!empty($info)){
			foreach($info as $k => $v){
				$img .= $v['savepath'].$v['savename'].',';
			}
			$img = trim($img,',');
			$thum = $info['files0']['savepath'].$info['files0']['savename'];
			$labels = trim($_POST['labels'],',');
			$data["images"] = $img;
			$data["thum"] = $thum;
			$data["type"] = 'img';
			$data["title"] = $_POST['title'];
			$data["infos"] = $_POST['infos'];
			$data["content"] = $_POST['content'];
			$data['createtime'] = date('Y-m-d H:i:s',time());
			$data["author"] = $id;
			$data["label"] = $labels;
			$data["right"] = $_POST['rights'];
			
			$works = M('works') -> add($data);
			if($works){
				$user = M('user') -> where("id = $id") -> field('works') -> find();
				if($user['works'] == ''){
					$str['works'] = $works;
				}else{
					$str['works'] = $user['works'].','.$works;
				}
				
				
				$userss = M('user') -> where("id = $id") -> save($str);
				
				$this->ajaxReturn($str);
			}else{
				$this->ajaxReturn('err2');
			}
			
		}else{
			$this->ajaxReturn('err1');
		}
		//$this->ajaxReturn($_POST);
	}
	
	//视频 vod
	public function textfile(){
		
		$id = $_COOKIE['id'];
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/'; // 设置附件上传根目录
		$upload->savePath  =     '/bluesnail/public/upload/'; // 设置附件上传（子）目录
		// 上传文件 
		$info   =   $upload->upload();
		
		if(!empty($info)){
			foreach($info as $k => $v){
				$img .= $v['savepath'].$v['savename'].',';
			}
			$img = trim($img,',');
			$thum = $info['files0']['savepath'].$info['files0']['savename'];
			$labels = trim($_POST['labels'],',');
			$data["thum"] = $thum;
			$data["type"] = 'text';
			$data["title"] = $_POST['title'];
			$data["infos"] = $_POST['infos'];
			$data["content"] = $_POST['content'];
			$data['createtime'] = date('Y-m-d H:i:s',time());
			$data["author"] = $id;
			$data["label"] = $labels;
			$data["right"] = $_POST['rights'];
			
			$works = M('works') -> add($data);
			if($works){
				$this->ajaxReturn($works);
			}else{
				$this->ajaxReturn('err2');
			}
			
		}else{
			$this->ajaxReturn('err1');
		}
		$this->ajaxReturn($_POST);
	}
	
	public function tuijian(){
		
		$data['imgid'] = $_POST['imgid'];
		$data['userid'] = $_POST['userid'];
		
		$res = M('tuijian') -> where($data) -> select();
		if(!$res){
			$data['createtime'] = date('Y-m-d H:i:s',time());
			$com = M('tuijian') -> add($data);
			if($com){
				$this->ajaxReturn(1);
			}else{
				$this->ajaxReturn(2);
			}
		}else{
			$this->ajaxReturn(0);
		}
	}
	
	public function lik(){
		
		$data['imgid'] = $_POST['imgid'];
		$data['userid'] = $_POST['userid'];
		
		$res = M('likework') -> where($data) -> select();
		//$this->ajaxReturn();
		if(!$res){
			
			$data['createtime'] = date('Y-m-d H:i:s',time());
			$com = M('likework') -> add($data);
			
			$this->ajaxReturn(1);
		}else{
			$da['id'] = $res[0]['id'];
			$com = M('likework') -> where($da) -> delete();
			
			$this->ajaxReturn(0);
		}
	}
	
	public function usermp(){
		//名片
		$id = $_POST['id'];
		
		$datas['userid'] = $id;
		$dataa['author'] = $id;
		$imgid = $_POST['imgid'];
		
		$wlen = M('works') -> where($dataa) -> count();
		$liklen = M('likework') -> where($datas) -> count();
		$flen = M('follow') -> where($datas) -> count();
		$data['id'] = $id;
		$works = M('user') -> where($data) -> select();
		
		$data1['author'] = $id;
		
		$res = M('works') -> where("author = $id and id != $imgid") -> order('createtime desc') -> limit(0,3) -> select();
		
		$works[0]['imgss'] = $res;
		$works[0]['wlen'] = $wlen;
		$works[0]['liklen'] = $liklen;
		$works[0]['flen'] = $flen;
		
		$this->ajaxReturn($works);
	}
	
	public function followadd(){
		
		$data['userid'] = $_POST['userid'];       //被关注者
		$data['follow_id'] = $_POST['follow_id']; //关注者
		
		$res = M('follow') -> where($data) -> select();
		//$this->ajaxReturn();
		if(!$res){
			$data['createtime'] = date('Y-m-d H:i:s',time());
			
			$com = M('follow') -> add($data);
			$this->ajaxReturn(1);
		}else{
			$da['id'] = $res[0]['id'];
			$com = M('follow') -> where($da) -> delete();
			$this->ajaxReturn(0);
		}
	}
	
	public function follow(){
		$id = cookie('id');
		$type = empty($_GET['type'])?0:$_GET['type'];
		$rep['userid'] = $id;
		$follow = M('follow') -> where($rep) -> count();
		$likework = M('likework') -> where($rep) -> count();
		
		$this -> assign('follow',$follow);
		$this -> assign('like',$likework);
		$this -> assign('id',$id);
		$this -> assign('type',$type);
		//var_dump($_GET);
		$this -> display('follow');
		
	}
	
	public function followlist(){
		
		$id = $_POST['id'];
		$type = $_POST['type'];
		$num = ($_POST['num'] - 1) * 8;
		
		$data['follow_id'] = $id;
		
		$f = M('follow');
		
		$follow = $f -> where($data) -> field('userid') -> limit($num,8) -> order('createtime desc') -> select();
		if($follow){
			foreach($follow as $k => $v){
				$str['id'] = $v['userid'];
				$str1['author'] = $v['userid'];
				$us = M('user') -> where($str) -> select();
				$work[$k] = $us[0];
				
				$times = M('works') -> where($str1) -> order('createtime desc') -> limit(0,8) -> field('createtime') -> select();
				$work[$k]['gxtime'] = date('Y/m/d H:i',strtotime($times[0]['createtime']));
			}
			
			$this->ajaxReturn($work);
		}else{
			$this->ajaxReturn($num);
		}
		
	}
	
	public function likes(){
		$id = cookie('id');
		$type = $_GET['type'];
		$rep['userid'] = $id;
		$follow = M('follow') -> where($rep) -> count();
		$likework = M('likework') -> where($rep) -> count();
		
		$this -> assign('follow',$follow);
		$this -> assign('like',$likework);
		
		$this -> assign('id',$id);
		$this -> assign('types',$type);
		$this -> display('likes');
		
	}
	
	public function news(){
		
		$id = cookie('id');
		
		$type = empty($_GET['type'])?'replys':$_GET['type'];
		$rep['userid'] = $id;
		$repre['userid'] = $id;
		$rep1['author'] = $id;
		if($type == 'likes'){
			$data = M('likework') -> where($rep1) -> count();
		}else if($type == 'tuijians'){
			$data = M('tuijian') -> where($rep1) -> count();
		}else if($type == 'replys'){
			$data = M('comment') -> where("author = $id and userid != $id") -> count();
		}else{
			$data = 1;
		}
		
		//$this -> assign('follow',$follow);
		$this -> assign('len',$data);
		$this -> assign('id',$id);
		$this -> assign('type',$type);
		//var_dump($data);
		$this -> display('news');
		
	}
	
	public function newslist(){
		
		$id = $_POST['id'];
		$type = $_POST['type'];
		$num = ($_POST['num'] - 1) * 8;
		
		$data['author'] = $id;
		
		//$m = M('likework');
		
		if($type == 'likes'){
			
			$res = M('likework') -> where($data) -> field('userid,imgid') -> limit($num,8) -> order('createtime desc') -> select();
		}else if($type == 'tuijians'){
			
			$res = M('tuijian') -> where($data) -> field('userid,imgid') -> limit($num,8) -> order('createtime desc') -> select();
		}else{
			
			$res = M('comment') -> where("author = $id and userid != $id") -> field('userid,imgid') -> limit($num,8) -> order('createtime desc') -> select();
			
		}
		
		if($res){
			foreach($res as $k => $v){
				
				$str['id'] = $v['userid'];
				
				$str2['id'] = $v['imgid'];
				$us = M('user') -> where($str) -> field('name,thum,id') -> select();
				$img = M('works') -> where($str2) -> field('title,thum,id,type,infos') -> select();
				$work[$k]['use'] = $us[0];
				$work[$k]['img'] = $img[0];
				
				$times = M('user') -> where($str1) -> order('createtime desc') -> limit(0,1) -> field('createtime') -> select();
				$work[$k]['gxtime'] = date('Y/m/d H:i',strtotime($times[0]['createtime']));
			}
			
			$this->ajaxReturn($work);
		}else{
			$this->ajaxReturn(0);
		}
		
	}
	
	//头像修改
	public function tx(){
		
		//$username = $_COOKIE['username'];
		$id = $_COOKIE['id'];
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->rootPath  =     './Public/'; // 设置附件上传根目录
		$upload->savePath  =     '/bluesnail/public/upload/'; // 设置附件上传（子）目录
								
		// 上传文件 
		$info   =   $upload->upload();
		$user = M('user');
		
		if(!empty($info) || !empty($_POST)){
			$txs = $user -> field('thum') -> where("id = '$id'") -> find();
			
			preg_match("/\w+.jpg$/",$txs['thum'],$arr);
			
			if($arr[0] != 'img01.jpg' && $arr[0] != 'img02.jpg' && $arr[0] != 'img03.jpg' && $arr[0] != 'img04.jpg'){
				
				$filename = 'Public'.$txs['thum'];
				unlink($filename);
			}
			//var_dump($arr[0]);
			if(!empty($info)){
				$thum = $info['thum']['savepath'].$info['thum']['savename'];
				$data["thum"] = $thum;
				$users = $user -> where("id = '$id'") -> save($data);
			}else{
				$urls = $_POST['txtx'];
				preg_match("/\w+.jpg$/",$urls,$arr);
				$str = '/bluesnail/images/upload/'.$arr[0];
				$data["thum"] = $str;
				$users = M('user')->where("id = '$id'")->save($data);
			}
			if($users){
				echo '<script language="javascript">window.location.href="'.U("Home/Painter/personal").'&authorid='.$id.'&mp=1";</script>';
			}
		}else{
			echo '<script language="javascript">window.location.href="'.U("Home/Painter/personal").'&authorid='.$id.'&mp=1";</script>';
		}
	}
	
	//画师信息修改 user 表
	public function userinfo(){
		
		$id = $_COOKIE['id'];
		$data['name'] = $_POST['name'];
		$data['sex'] = $_POST['sex'];
		$data['address'] = $_POST['address'];
		$data['honor1'] = $_POST['honor1'];
		$data['honor2'] = $_POST['honor2'];
		$data['honor3'] = $_POST['honor3'];
		$data['sflabel'] = $_POST['sflabel'];
		$data['oldlabel'] = $_POST['oldlabel'];
		$data['gxlabel'] = $_POST['gxlabel0'].','.$_POST['gxlabel1'].','.$_POST['gxlabel2'];
		$data['qq'] = $_POST['qq'];
		$data['weibo'] = $_POST['weibo'];
		$data['weixin'] = $_POST['weixin'];
		$data['email'] = $_POST['email'];

		$user = M('user')->where("id = '$id'")->save($data);
		
		if($user){
			$this->success("修改成功",$this->site_url,1);
		}else{
			//var_dump($id);
			//var_dump($user);
			//var_dump($data);
			$this->error("修改失败",$this->site_url,1);
		}
	}
	
	
	
	
	
	
	
	
	
}