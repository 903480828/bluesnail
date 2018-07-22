<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<title>个人主页</title>
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
<link rel="stylesheet" href="/bluesnail/Public/bluesnail/style/snail-personal.css">
	<div class='cont'>
		<div class='card'>
			<img src="/bluesnail/Public/<?php echo ($users["thum"]); ?>" alt="">
			<div class='card-info'>
				<p>昵称：<?php echo ($users["name"]); ?><span>我的ID：<?php echo ($users["id"]); ?></span></p>
				<p>地点：<?php echo ($users["add"]); ?> <span>性别：<?php echo ($users["sex"]); ?></span></p>
				<div class='honor clearfix'>
					荣誉：
					<p><?php echo ($users["honor1"]); ?></p>
					<p><?php echo ($users["honor2"]); ?></p>
					<p><?php echo ($users["honor3"]); ?></p>
				</div>
				<p>个性标签：<span><?php echo ($users["sflab"]); ?></span><span><?php echo ($users["oldlab"]); ?></span>
					<?php if(is_array($users["gxlab"])): foreach($users["gxlab"] as $key=>$va): ?><span><?php echo ($va); ?></span><?php endforeach; endif; ?>
				</p>
				<div class='cin clearfix'>
					联系方式：<p><span>QQ：<?php echo ($users["qq"]); ?></span><nobr>微信：<?php echo ($users["weixin"]); ?></nobr><br><span>微博：@<?php echo ($users["weibo"]); ?></span><nobr>邮箱：<?php echo ($users["email"]); ?></nobr></p>
				</div>
			</div>
			<?php  if($users['id'] == $_COOKIE['id']){ ?>
			<div class='setup'><a href="javascript:void">设置个人名片</a></div>
			<?php  } ?>
		</div>
		<h2><?php echo ($users["name"]); ?></h2>
		<div class='con-nav'><a href='javascript:void(0)' class='act'>名片</a>|<a href='javascript:void(0)' class='follows' data='<?php echo ($users["id"]); ?>'><?php echo ($follows); ?></a></div>
		<div class='ff'></div>
		<div class='mail'>
			<ul class='mail-c clearfix' id='main'></ul>
		</div>
	</div>
<?php  if($users['id'] == $_COOKIE['id']){ ?>
<div id='einfo'>
	<div class='ef-left'>
		<form method="post" action="<?php echo U('Home/Painter/tx');?>" enctype="multipart/form-data" onsubmit="return iframeCallback(this,dialogAjaxDone);" class='tx'>
			<div><img src="/bluesnail/Public/<?php echo (cookie('thum')); ?>" id='img0' alt="" /></div>
			<input type="file" title='点击更换头像' name='thum' />
			<input type="hidden" name='txtx' id='txtx' value='' />
			<button style='display:none;'>保存头像</button>
		</form>
		<div class='ybtx'>
			<img src="/bluesnail/Public/bluesnail/images/upload/img01.jpg" title='点击更换头像' alt="" />
			<img src="/bluesnail/Public/bluesnail/images/upload/img02.jpg" title='点击更换头像' alt="" />
			<img src="/bluesnail/Public/bluesnail/images/upload/img03.jpg" title='点击更换头像' alt="" />
			<img src="/bluesnail/Public/bluesnail/images/upload/img04.jpg" title='点击更换头像' alt="" />
		</div>
	</div>
		
	<div class='ef-right'>
		<form method="post" action="<?php echo U('Home/Painter/userinfo');?>" enctype="multipart/form-data" onsubmit="return iframeCallback(this,dialogAjaxDone);">
			<p>昵称：<input type="text" name='name' value='<?php echo ($users["name"]); ?>'> <span>我的ID：<?php echo ($users["id"]); ?></span></p>
			<p>性别：
			<?php if($users["sex"] == 男 ): ?><input type="radio" name='sex' value='男' checked id='sexb'><label for="sexb">男</label>
			<input type="radio" name='sex' value='女' id='sexg'><label for="sexg">女</label>
			<?php else: ?>
			<input type="radio" name='sex' value='男' id='sexb'><label for="sexb">男</label>
			<input type="radio" name='sex' value='女' checked id='sexg'><label for="sexg">女</label><?php endif; ?>
			
			<span>地点：</span>
			<select name="address" id="addres">
				<?php if(is_array($addr)): foreach($addr as $key=>$vi): ?><option value="<?php echo ($vi["id"]); ?>" <?php if($vi["id"] == $users["address"] ): ?>selected<?php endif; ?> ><?php echo ($vi["address"]); ?></option><?php endforeach; endif; ?>
			</select></p>
			<div class='honor clearfix'>
				<span>荣誉：</span><br>
				<input type="text" name='honor1' value='<?php echo ($users["honor1"]); ?>' /><br>
				<input type="text" name='honor2' value='<?php echo ($users["honor2"]); ?>' /><br>
				<input type="text" name='honor3' value='<?php echo ($users["honor3"]); ?>' /><br>
			</div>
			<p class='bq'>个性标签：<select name="sflabel" name='sflabel' id="">
						<option value="">请选择</option>
					<?php if(is_array($sflabel)): foreach($sflabel as $key=>$vsf): ?><option value="<?php echo ($vsf["id"]); ?>" <?php if($vsf["id"] == $users["sflabel"] ): ?>selected<?php endif; ?> ><?php echo ($vsf["label"]); ?></option><?php endforeach; endif; ?>
				</select>
				<select name="oldlabel" name='oldlabel' id="">
					<option value="">请选择</option>
					<?php if(is_array($oldlabel)): foreach($oldlabel as $key=>$vold): ?><option value="<?php echo ($vold["id"]); ?>" <?php if($vold["id"] == $users["oldlabel"] ): ?>selected<?php endif; ?> ><?php echo ($vold["label"]); ?></option><?php endforeach; endif; ?>
				</select>
				<?php if(is_array($users["gx"])): foreach($users["gx"] as $key=>$vo): ?><select name="gxlabel<?php echo ($key); ?>" name='sflabel' id="">
					<option value="">请选择<?php echo ($vo); ?></option>
					<?php if(is_array($gxlabel)): foreach($gxlabel as $key=>$vgx): ?><option value="<?php echo ($vgx["id"]); ?>" <?php if($vgx["id"] == $vo ): ?>selected<?php endif; ?> ><?php echo ($vgx["label"]); ?></option><?php endforeach; endif; ?>
				</select><?php endforeach; endif; ?>
			</p>
			<div class='cin clearfix'>
				联系方式：<p><span>Q&nbsp;Q：</span><input type="text" name='qq' value='<?php echo ($users["qq"]); ?>'><span>微信：</span><input type="text" name='weixin' value='<?php echo ($users["weixin"]); ?>'></p><p><span>微博：</span><input type="text" name='weibo' value='<?php echo ($users["weibo"]); ?>'><span>邮箱：</span><input name='email' type="text" value='<?php echo ($users["email"]); ?>'></p>
			</div>
			<button>保&nbsp;存</button>
		</form>
	</div>
</div>
<div id='editinfo'></div>
<?php
} ?>
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
<script>
$(function(){
	$('.card').hide();
		$(".act").toggle(
			function(){
				$(window).scrollTop(0);
				//$('.card').show().animate({'margin-top':'0px','top':'0px'},5000,'linear');
				$('.card').slideDown();
				
			},
			function(){
				//$('.card').animate({'top':'-500px','margin-top':'-324px'},500,function(){$('.card').hide();});
				$('.card').slideUp();
			}
		);
	$('.setup').on('click',function(){$('#editinfo').show();$('#einfo').show();});
	$('#editinfo').on('click',function(){$('#editinfo').hide();$('#einfo').hide();});

	if(<?php echo ($mp); ?> == 1){
		$('.card').show().css({'top':'0px','margin-top':'0px'});
	}
	
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
	
	function imgloads(){
		var str = '';
		$.ajax({
			url:'<?php echo U("Home/painter/personallist");?>',
			data:{authorid:<?php echo ($users['id']); ?>,num:num},
			type:'post',
			success:function(msg){
				if(msg == ''){
					alert('没有跟多了亲~');
				}else{
					//ajax请求的数据
					//console.log(msg)
					for( var i=0; i<msg.length; i++){
						//console.log(msg[i].thum);
						str += '<li><a href="<?php echo U("Home/painter/details");?>&authorid=' + msg[i].author + '&imgid=' + msg[i].id + '"><img src="/bluesnail/Public/' + msg[i].thum + '" alt="作品"></a><h5><a href="<?php echo U("Home/painter/details");?>&authorid=' + msg[i].author + '&imgid=' + msg[i].id + '">' + msg[i].title + '</a></h5><div class="x-info"><p>' + msg[i].lab + '</p><p><span>' + msg[i].times + '</span></p></div></li>'
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
					span.text('关注');
				}else if(msg == 1){
					span.text('已关注');
				}
			});
		}
	});
	
	$('html').on('click','.ybtx img',function(){
		var s = $(this).attr('src');
		$("#img0").attr("src", s);
		$('.tx button').css('display','block');
		$('#txtx').val(s);
		console.log($(this).attr('src'));
		
	});
	
	$('html').on('change','.tx input',function(){
		var objUrl = getObjectURL(this.files[0]) ;
		if (objUrl){
			$("#img0").attr("src", objUrl);
			$("#img0").removeClass("hide");
	    }
		$('.tx button').css('display','block');
		//console.log("objUrl = "+objUrl) ;
	});
	
	//获取上传图片的src
	function getObjectURL(file){
	    var url = null ;
	    if (window.createObjectURL!=undefined) 
	    { // basic
	      url = window.createObjectURL(file) ;
	    }
	    else if (window.URL!=undefined) 
	    {
	      // mozilla(firefox)
	      url = window.URL.createObjectURL(file) ;
	    } 
	    else if (window.webkitURL!=undefined) {
	      // webkit or chrome
	      url = window.webkitURL.createObjectURL(file) ;
	    }
	    return url ;
	}
	
	
});
</script>