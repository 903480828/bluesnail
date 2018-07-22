<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
	<title>作品详情页</title>
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
<link rel="stylesheet" href="/bluesnail/Public/bluesnail/style/snail-details.css">
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
			<?php
 if($_COOKIE["username"] == $users["name"] && $users["id"] == $_COOKIE["id"]){ ?>
			<div class='setup'><a href="javascript:void">设置个人名片</a></div>
			<?php  } ?>
		</div>
		<h2><?php echo ($users["name"]); ?></h2>
		<div class='con-nav'><a href='javascript:void(0)' class='act'>名片</a>|<a href='javascript:void(0)' class='follows' data='<?php echo ($users["id"]); ?>'><?php echo ($follows); ?></a></div>
		<div class='ff'></div>
		<div class='mail'>
			<div class='m-01'>
				<div id='operation'>
				<?php  if($users["id"] == $_COOKIE["id"]){ ?>
					<ul class='own'>
						<li><a href="javascript:void(0)" >编辑</a></li>
						<li><a href="javascript:void(0)" >删除</a></li>
						<li><a href="javascript:void(0)" >分享</a></li>
					</ul>
				<?php  }else{ ?>
					<ul class='other'>
						<li><a href="javascript:void(0)">举报</a></li>
						<li><a href="javascript:void(0)" class='lik'><b class='<?php echo ($on); ?>'></b></a></li>
						<li><a href="javascript:void(0)">分享</a></li>
						<li><a href="javascript:void(0)" class='tuijian'>推荐</a></li>
					</ul>
				<?php  } ?>
				</div>
				<?php if($imgs["type"] == 'text'): ?><div id='works' class='bd'>
					<ul class='clearfix'>
						<li><img src="/bluesnail/Public/<?php echo ($imgs["thum"]); ?>" alt="作品"></li>
					</ul>
				</div>
				<div class='m1-01 m1-01-text'>
					<h5><?php echo ($imgs["title"]); ?></h5>
					<div class='m11-con'><?php echo ($imgs["content"]); ?></div>
					<div class='m11-bq'>
						<img src="/bluesnail/Public/<?php echo ($imgs["rthum"]); ?>" alt="<?php echo ($imgs["right"]); ?>" title = "<?php echo ($imgs["right"]); ?>" > <b title="<?php echo ($imgs["rinfo"]); ?>"></b>
						<p><?php echo ($imgs["lab"]); ?></p>
					</div>
					<div></div>
				</div>
				<?php elseif($imgs["type"] == 'img'): ?>
				<div id='works' class='bd'>
					<ul class='clearfix'>
						<?php if(is_array($imgs["img"])): foreach($imgs["img"] as $key=>$vi): ?><li><img src="/bluesnail/Public/<?php echo ($vi); ?>" alt="作品"></li><?php endforeach; endif; ?>
					</ul>
					<span class='b-prev prev'></span>
					<span class='b-next next'></span>
				</div>
				<div class='m1-01'>
					<h5><?php echo ($imgs["title"]); ?></h5>
					<div class='m11-con'><?php echo ($imgs["content"]); ?></div>
					<div class='m11-bq'>
						<img src="/bluesnail/Public/<?php echo ($imgs["rthum"]); ?>" alt="<?php echo ($imgs["right"]); ?>" title = "<?php echo ($imgs["right"]); ?>" > <b title="<?php echo ($imgs["rinfo"]); ?>"></b>
						<p><?php echo ($imgs["lab"]); ?></p>
					</div>
					<div></div>
				</div><?php endif; ?>
			</div>
			<div class='addsnail'><a href="###">加入蓝色蜗牛，与TA一起来互动</a></div>
			<div class='m-cont'>
				<div class='m-02'>
					<h4>其他作品</h4>
					<div id='qt-works'>
						<div class='bd'>
							<ul class='clearfix'>
								<?php if(is_array($xgimg)): foreach($xgimg as $key=>$vt): ?><li><a href="<?php echo U('Home/painter/details');?>&authorid=<?php echo ($vt["author"]); ?>&imgid=<?php echo ($vt["id"]); ?>"><img src="/bluesnail/Public/<?php echo ($vt["thum"]); ?>" alt="作品"></a></li><?php endforeach; endif; ?>
							</ul>
						</div>
						<span class='x-prev prev'></span>
						<span class='x-next next'></span>
					</div>
				</div>
				<div class='m-03 clearfix'>
					<div>
						<h4 id='len'>全部评论</h4>
						<ul id='comment'></ul>
						
						<div class='pl'>点击查看更多评论</div>
						
					</div>
					<form action="javascript:void(0)" method='post' class='clearfix'>
						<textarea name="content" id="content" cols="30" rows="10" placeholder="你想说点什么..."></textarea>
						<button id='comb'>评&nbsp;论</button>
					</form>
				</div>
			</div>
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
		jQuery(".m-01").slide({mainCell:".bd ul",effect:"left",trigger:"click",delayTime:1000});
		jQuery(".m-02").slide({mainCell:".bd ul",autoPage:true,effect:"left",vis:3,trigger:"click"});
		for(var i=0; i<$('#works li img').length; i++){
			var w = $('#works li img').eq(i).width();
			var h = $('#works li img').eq(i).height();
			if(w > h){
				$('#works li img').eq(i).css('width','780px');
			}else{
				$('#works li img').eq(i).css('height','648px');
			}
		}
		
		// 名片控制
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
		
		// 名片弹出

		var lens = $('#qt-works ul li').length;
		$('#qt-works ul').css('width',lens * 230 + 'px');
		
		var num = 0;
		var len = 0;
		var user = 1;
		//reply();
		
		$('.pl').on('click',function(){
			reply();
		});;
		
		reply();
		//ajax获取评论
		function reply(){
			$.ajax({
				url:'<?php echo U("Home/Painter/commentlise");?>',
				type:'post',
				data:{id:<?php echo ($id); ?>,num:num},
				success:function(msg){
					//console.log(msg);
					if(msg == '' & user == 0){
						alert('没有跟多了亲~');
					}else{
						user = 0;
						var str = '';
						for(var i=0; i<msg.length; i++){
						
							str += '<li class="clearfix"><div class="c-title"><a href="<?php echo U("Home/painter/personal");?>&authorid=' + msg[i]["author_id"] + '"><img src="/bluesnail/Public/' + msg[i]["author_thum"] + '" alt="' + msg[i]["author"] + '"><h6>' + msg[i]["author"] + '</h6></a><span>' + msg[i]["create"] + '</span></div><div class="content clearfix"><div class="comment">' + msg[i]["content"] + '</div><span title="回复" data="' + msg[i]["author_id"] + '" data_name="' + msg[i]["author"] + '" reply_type="1" z_id="' + msg[i]["id"] + '" class="replys">...</span></div>';

							if(msg[i]["reply"] != undefined){
								for(var j=0; j<msg[i]["reply"].length; j++){
								
									if(msg[i]["reply"][j]["reply_type"] == 1){
										str += '<div class="hf clearfix"><h6><a href="<?php echo U("Home/painter/personal");?>&authorid=' + msg[i]["reply"][j]["author_id"] + '">' + msg[i]["reply"][j]["author"] + '</a><span class="times">' + msg[i]["reply"][j]["create"] + '<?php echo ($vs["create"]); ?></span></h6><div>' + msg[i]["reply"][j]["content"] + '</div><span title="回复" data="' + msg[i]["reply"][j]["author_id"] + '" data_name="' + msg[i]["reply"][j]["author"] + '" reply_type="2" p_id="' + msg[i]["id"] + '" z_id="' + msg[i]["reply"][j]["id"] + '" class="replys">...</span></div>';
									}else if(msg[i]["reply"][j]["reply_type"] == 2){
										str += '<div class="hf clearfix"><h6><a href="<?php echo U("Home/painter/personal");?>&authorid=' + msg[i]["reply"][j]["author_id"] + '">' + msg[i]["reply"][j]["author"] + '</a><span>回复</span><a href="<?php echo U("Home/painter/personal");?>&authorid=' + msg[i]["reply"][j]["to_uid"] + '">' + msg[i]["reply"][j]["reply_name"] + '</a><span class="times">' + msg[i]["reply"][j]["create"] + '</span></h6><div>' + msg[i]["reply"][j]["content"] + '</div><span title="回复" data="' + msg[i]["reply"][j]["author_id"] + '" data_name="' + msg[i]["reply"][j]["author"] + '" reply_type="2" p_id="' + msg[i]["id"] + '" z_id="' + msg[i]["reply"][j]["id"] + '" class="replys">...</span></div>';
									}
								}
							}
							str += '</li>';
						}
						//$('#comment').empty();
						$('#comment').append(str);
						//$('#len').text(len);
						num = num + 10;
						if($('#comment li').length<1){
							$('.pl').css('display','none');
							$('#len').html('<span>暂无评论</span>');
						}else if($('#comment li').length<10){
							$('.pl').css('display','none');
							$('#len').text('全部评论');
						}else{
							$('.pl').css('display','block');
							$('#len').text('全部评论');
						}
					}
				},
				error:function(err){
					console.log(err);
				}
			});
		};
		
		$('#comb').on('click',function(){
			var name = $.cookie('username');
			var userid = $.cookie('id');
			if(name == undefined & userid == undefined){
				alert('请您先登录');
				window.location.href='<?php echo U("Home/User/index");?>'
				
			}else{
				
				var val = $('#content').val();
				var count = val.length;
				
				if(val == ''){
					alert('内容不能为空');
					
				}else if(count > 200){
					alert('您输入的内容超过了200字数限制');
				}else{
					$.post('<?php echo U("Home/Painter/comment");?>',{value:val,imgid:<?php echo ($id); ?>,author:<?php echo ($author); ?>,userid:userid},function(msg){
						
						if(msg == 1){
							alert('评论成功');
							window.location.reload();
						}else{
							alert('评论失败');
						}
					});
				}
			}
		});
		
		$('#comment').on('click','.replys',function(){
			var name = $.cookie('username');
			var authorid = $.cookie('id');
			if(name == undefined & authorid == undefined){
				alert('请您先登录');
				window.location.href='<?php echo U("Home/User/index");?>'
				
			}else{
				$('#rep').remove();
				to_name = $(this).attr('data_name');
				to_uid = $(this).attr('data');
				z_id = $(this).attr('z_id');
				p_id = typeof($(this).attr('p_id')) == 'undefined' ? $(this).attr('z_id') : $(this).attr('p_id');
				name = $.cookie('username');
				userid = $.cookie('id');
				reply_type = $(this).attr('reply_type');
				comment_id = p_id;
				reply_id = z_id;
				
				$(this).parent().append('<p id="rep"><input type="text" placeholder="回复&nbsp;&nbsp;' + to_name + '：" /><button id="rebtn">发表</button></p>');
			}
		});
		
		
		$('#comment').on('click','#rebtn',function(){
			var val = $('#rep input').val();
			var count = $('#rep input').val().length;
			if(val == ''){
				//alert('内容不能为空');
			}else if(count > 200){
				//alert('您输入的内容超过了200字数限制');
			}else{
				$.post('<?php echo U("Home/Painter/reply");?>',{value:val,comment_id:comment_id,reply_id:reply_id,to_uid:to_uid,userid:userid,reply_type:reply_type},function(msg){ 
					console.log(msg); 
					if(msg == 1){ 
					alert('评论成功'); 
					window.location.reload(); 
					}else{ 
						alert('评论失败'); 
					} 
				}); 
			}
		});
		
		
		$('html').on('click','.tuijian',function(){
			//console.log();
			if($.cookie('id') == undefined){
				alert('请您先登录');
				window.location.href="<?php echo U('Home/User/index');?>";
			}else{
				
				var id = $(this).attr('data');
				var userid = $.cookie('id') == undefined?0:$.cookie('id');
				$.post('<?php echo U("Home/Painter/tuijian");?>',{imgid:<?php echo ($imgs["id"]); ?>,userid:userid},function(msg){
					//console.log(msg);
					if(msg == 0){
						alert('亲，您已经推荐过了');
					}else if(msg == 1){
						alert('亲，推荐成功');
					}else if(msg == 2){
						alert('亲，推荐失败，您刷新下试试吧');
					}
				});
			}
		});
		
		$('html').on('click','.lik',function(){
			if($.cookie('id') == undefined){
				alert('请您先登录');
				window.location.href="<?php echo U('Home/User/index');?>";
			}else{
				
				var b = $(this).children('b');
				var userid = $.cookie('id') == undefined?0:$.cookie('id');
				$.post('<?php echo U("Home/Painter/lik");?>',{imgid:<?php echo ($imgs["id"]); ?>,userid:userid},function(msg){
					console.log(msg);
					if(msg == 0){
						b.removeClass('on');
					}else if(msg == 1){
						b.addClass('on');
					}
				});
			}
		});
		
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
		
		$(".on").toggle(
			function(){
				$('.card').show().animate({'top':'0px','margin-top':'0px'},1200);
				$(window).scrollTop(0);
			},
			function(){
				$('.card').animate({'top':'-500px','margin-top':'-324px'},500,function(){$('.card').hide();});
			}
		);
		
		$('.setup').on('click',function(){$('#editinfo').show();$('#einfo').show();});
		$('#editinfo').on('click',function(){$('#editinfo').hide();$('#einfo').hide();});

		if(<?php echo ($mp); ?> == 1){
			$('.card').show().css({'top':'0px','margin-top':'0px'});
		}
		
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