<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<title>画师</title>
	<link rel="stylesheet" href="/bluesnail/Public/bluesnail/style/header.css">
	<link rel="stylesheet" href="/bluesnail/Public/bluesnail/style/index.css">
	<script src='/bluesnail/Public/bluesnail/js/jquery-1.8.3.min.js'></script>
	<script src='/bluesnail/Public/bluesnail/js/header.js'></script>
	<script src='/bluesnail/Public/bluesnail/js/jquery.cookie.js'></script>
	<script src='/bluesnail/Public/bluesnail/js/jquery.SuperSlide.2.1.1.js'></script>
</head>
<body>
	<div class='header'>
		<a class='logo' href='<?php echo U("Home/Index/index");?>'>Blue Snail</a>
		<div class='head-r'>
			<a href="<?php echo U("Home/Painter/dynamic");?>">我的动态</a>
			<form action="<?php echo U("Home/Index/sousuo");?>" method='post' class='search'>
				<input type="text" name='label' value='[sousuo]' placeholder="标签" >
				<button>搜索</button>
			</form>
			<div class='nav'>
				<ul>
					<li><a href="#">意见反馈</a></li>
					<li><a href="#">联系我们</a></li>
					<li><a href="#">账号设置</a></li>
					<li><a href="#">关于我们</a></li>
					<li><a href="#">退出</a></li>
				</ul>
			</div>
			<div class='login'>
				<?php  if(!$_COOKIE['username']){ ?>
				<a href="<?php echo U('Home/User/register');?>">注册</a>
				<a href="<?php echo U('Home/User/index');?>">登录</a>
				<?php  }else{ ?>
				<a class='thums' href="<?php echo U('Home/painter/personal');?>&authorid=<?php echo (cookie('id')); ?>"><img src="/bluesnail/Public/<?php echo (cookie('thum')); ?>" alt="<?php echo (cookie('username')); ?>" title="<?php echo (cookie('username')); ?>" /></a>
				<a href="<?php echo U('Home/User/logout');?>" >退出</a>
				<?php  } ?>
				
			</div>
		</div>
	</div>
	<script type="text/javascript">
		$(function(){
			var label = $('input[name=label]').val();
			if(label == '['+'sousuo'+']'){
				$('input[name=label]').val('');
			}
		});
	</script>
<link rel="stylesheet" href="/bluesnail/Public/bluesnail/style/index-painter.css">
	<div class='banner clearfix'>
		<div class='banner_lb'>
		<?php if(is_array($ban)): foreach($ban as $key=>$vo): ?><img src="/bluesnail/Public/<?php echo ($vo["url"]); ?>" alt="banner图"><?php endforeach; endif; ?>
		</div>
		<div>
			<ul class='banner_btn hd clearfix'>
				<li class='on'></li>
				<li></li>
				<li></li>
			</ul>
		</div>
	</div>
	<div class='cont'>
		<div class='con-nav'><a href='<?php echo U("Home/index/index");?>' class='on'>作品</a>|<a href='<?php echo U("Home/painter/index");?>'>达人</a></div>
		<div class='mail'>
			<ul class='mail-c clearfix' id='main'></ul>
		</div>
	</div>
	<div class='footer'>
		<ul class='clearfix'>
			<li><a href="###">联系我们</a></li>
			<li><a href="###">本站方针</a></li>
			<li><a href="###">版权声明</a></li>
			<li><a href="###">隐私政策</a></li>
			<li><a href="###">使用政策</a></li>
		</ul>
	</div>
</body>
</html>
<script type="text/javascript">
$(function(){

	jQuery(".banner").slide({mainCell:".banner_lb",effect:"leftLoop",autoPlay:true,delayTime:700});
	var num = 0;
	var p = 0;
	imgloads();
	
	$(window).on('scroll',function(){
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		
		if (scrollTop + windowHeight == scrollHeight){
		// 此处是滚动条到底部时候触发的事件，在这里写要加载的数据，或者是拉动滚动条的操作
			imgloads();
		}
	});
	
	function imgloads(){
		var str = '';
		var id = $.cookie('id') == undefined?0:$.cookie('id');
		//console.log(num);
		$.ajax({
			url:'<?php echo U("Home/painter/loads");?>',
			data:{num:num,id:id},
			type:'post',
			success:function(msg){
				console.log(msg);
				if(msg == '' & p == 0){
					alert('没有跟多了亲~');
				}else{
					p = 1;
					//ajax请求的数据
					for( var i=0; i<msg.length; i++){
						
						var cls = '';
						if(msg[i].follows == 1){
							cls = 'on';
						}
						str += '<li><a href="<?php echo U("Home/painter/personal");?>&authorid=' + msg[i].id + '"><img src="/bluesnail/Public/' + msg[i].thum + '" alt="头像"></a><h5><a href="<?php echo U("Home/painter/personal");?>&authorid=' + msg[i].id + '">' + msg[i].name + '</a></h5><div class="biaoqian">' + msg[i].lab + '</div><span class="follows ' + cls + '" data="' + msg[i].id + '" >关&nbsp;注</span><p class="clearfix"><a href="<?php echo U("Home/painter/details");?>&authorid=' + msg[i].id + '&imgid=' + msg[i].urls0.id + '"><img src="/bluesnail/Public/' + msg[i].urls0.thum + '" alt="作品"></a><a href="<?php echo U("Home/painter/details");?>&authorid=' + msg[i].id + '&imgid=' + msg[i].urls1.id + '"><img src="/bluesnail/Public/' + msg[i].urls1.thum + '" alt="作品"></a></p></li>'
					}
					$('#main').append(str);
					
					num += 8;
				}
			},
			error:function(err){
				console.log(err);
			}
		});
	}
	
	$('html').on('click','.follows',function(){
		if($.cookie('id') == undefined){
			alert('请您先登录');
			window.location.href="<?php echo U('Home/User/Index');?>";
		}else{
			var span = $(this);
			var userid = $(this).attr('data');
			var follow_id = $.cookie('id') == undefined?0:$.cookie('id');
			$.post('<?php echo U("Home/Painter/followadd");?>',{userid:userid,follow_id:follow_id},function(msg){
				console.log(msg);
				if(msg == 0){
					span.removeClass('on');
				}else if(msg == 1){
					span.addClass('on');
				}
			});
		}
	});
	
});
</script>