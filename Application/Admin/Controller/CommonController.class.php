<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
   
    public function __construct(){
		parent::__construct();
		$username = $_SESSION['username'];
		if(empty($username)){
			$this->error('请您先登录后台',__APP__.'/Admin/Index/login',2);
		}
		
	}
	
	public function verify_c(){
		$Verify = new \Think\Verify();  
		$Verify->fontSize = 20;  
		$Verify->length   = 4;  
		$Verify->useNoise = false;  
		$Verify->codeSet = '0123456789';  
		$Verify->imageW = 130;  
		$Verify->imageH = 50;  
		//$Verify->expire = 600;
		$Verify->entry();
	}
	
}