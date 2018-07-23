<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {

    public function index(){
		session_start();
		header("Content-Type: text/html;charset=utf-8");
		
		//var_dump(strtolower(__CONTROLLER__));
		//记录除了User控制器下的所有路径 达到登陆后返回之前那打开网页的效果
		
		if(strtolower(__CONTROLLER__)!="/bluesnail/index.php/home/user"){
			cookie('url_current',__SELF__);
		}
		$id = $_COOKIE['id'];
		if(!empty($id)){
			$list = M('user') -> where($data) ->select();
			$username = empty($list[0]['name'])?$list[0]['phone']:$list[0]['name'];
			$thum = empty($list[0]['thum'])?$list[0]['thum']:$list[0]['thum'];
			cookie('username',$username);
			cookie('thum',$thum);
		}
		
		//var_dump($id);
	}
	
	// public function verify_c(){
		// session_start();
		// $Verify = new \Think\Verify();  
		// $Verify->fontSize = 16;  
		// $Verify->length   = 4;  
		// $Verify->useNoise = false;  
		// $Verify->codeSet = '0123456789';  
		// $Verify->imageW = 130;  
		// $Verify->imageH = 30;  
		// $Verify->expire = 600;
		// $Verify->entry();
	// }
	
}