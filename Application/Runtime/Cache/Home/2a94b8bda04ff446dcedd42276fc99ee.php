<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<title>首页</title>
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
		<div class='ff'></div>
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
	imgloads();
	
	$(window).on('scroll',function(){
		var scrollTop = $(this).scrollTop();
		var scrollHeight = $(document).height();
		var windowHeight = $(this).height();
		
		if (scrollTop + windowHeight == scrollHeight) {
		// 此处是滚动条到底部时候触发的事件，在这里写要加载的数据，或者是拉动滚动条的操作
			imgloads();
		}
		
	});
	var pd = 1;
	function imgloads(){
		var str = '';
		
		var id = $.cookie('id') == undefined?0:$.cookie('id');
		//console.log(id);
		$.ajax({
			url:'<?php echo U("Home/Index/pbl");?>',
			data:{num:num,id:id},
			type:'post',
			success:function(msg){
				if(msg == '' & pd == 0){
					alert('没有跟多了亲~');
				}else{
				
					pd = 0;
					//ajax请求的数据
					for( var i=0; i<msg.length; i++){
						var cls = '';
						if(msg[i].likess == 1){
							cls = 'on';
						}
						str += '<li class="box"><a href="<?php echo U("Home/painter/details");?>&authorid=' + msg[i].author + '&imgid=' + msg[i].id + '"><img src="/bluesnail/Public/' + msg[i].thum + '" alt="' + msg[i].title + '"></a><div><h5><a href="<?php echo U("Home/painter/personal");?>&authorid=' + msg[i].author + '"><img src="/bluesnail/Public/' + msg[i].tx + '" alt="头像"></a><a href="<?php echo U("Home/painter/personal");?>&authorid=' + msg[i].author + '">' + msg[i].zz + '</a></h5><div class="x-info"><p>' + msg[i].lab + '</p><p><b data="' + msg[i].id + '" class="lik ' + cls + '" ></b><span>' + msg[i].liklen + '</span></p></div></div></li>'
					}
					$('#main').append(str);
					$('.box>a>img').load(function(){
						pul();
					});
					num += 8;
				}
			},
			error:function(err){
				console.log(err);
			}
		});
	}
	
	function pul(){
	    var boxli = $('.box').length;
	    var heightArr = [];
	    for(var i=0; i<boxli; i++){
	    	var num = 0;
	    	num = i;
	        var boxHeight = $('.box').eq(i).outerHeight();
	        if(i<4){
	            heightArr.push(boxHeight);
	        }else{
	            var minBoxHeight = Math.min.apply(this,heightArr);
	            //求出最矮盒子对应的索引
	            var maxBoxHeight = Math.max.apply(this,heightArr);
	            //求出最高盒子对应的索引
	            var minBoxIndex = getMinBoxIndex(minBoxHeight,heightArr);
	            //盒子瀑布流定位  顶部间距就是最矮盒子的高度
	            $('.box').eq(i).css({'position':'absolute','top':minBoxHeight + 20 + 'px','left':minBoxIndex * 280 + minBoxIndex * 20 + 'px'});
	            //关键:更新数组最矮高度,使下一个图片在高度数组中总是找最矮高度的图片下面拼接
	            heightArr[minBoxIndex] += boxHeight + 20;
	            
	        }
	    }
	    $('#main').height(maxBoxHeight + 150);
		console.log(maxBoxHeight);
		console.log(boxHeight);
	    
	}

	//求出最矮盒子对应的索引函数
	function getMinBoxIndex(val,arr) {
	    for(var i in arr)
	    {
	        if(val == arr[i])
	        {
	            return i;
	        }
	    }
	}
	
	$('html').on('click','.lik',function(e){
		if($.cookie('id') == undefined){
			alert('请您先登录');
			window.location.href="<?php echo U('Home/User/index');?>";
		}else{
			var b = $(this)
			var id = $(this).attr('data');
			var userid = $.cookie('id') == undefined?0:$.cookie('id');
			$.post('<?php echo U("Home/Painter/lik");?>',{imgid:id,userid:userid},function(msg){
				console.log(msg);
				
				if(msg == 0){
					b.removeClass('on');
				}else if(msg == 1){
					b.addClass('on');
				}
			});
		}
	});
})
</script>