$(function(){

	//点击添加标签
	$('#up-img .texts>p>span').on('click',function(){
		var len = $("#up-img .bq-t span").length;
		if(len > 2){
			alert('标签不能超过3个');
		}else{
			$('#up-img .bq-t').append($(this));
			
		}
	});
	//空格或回车生成标签
	$('#up-img .bq-b>input').on('keydown',function(e){
		var vals = $('#up-img .bq-b>input').val();
		var len = $("#up-img .bq-t span").length;
		var e = e || window.event;
		if(e.keyCode == 32 || e.keyCode == 13){
			if(len > 2){
				alert('标签不能超过3个');
			}else if($.trim(vals) != ''){
				var str = '<span>' + $.trim(vals) + '<a href="javascript:void(0)"></a></span>'
				$('#up-img .bq-t').append(str);
				$('#up-img .bq-b>input').val(null);
			}
		}else if(e.keyCode == 8 && vals === ''){
			//	按下删除键 且 input 不为空就删除最后一个标签
			$('#up-img .bq-t span:last-child').remove();
		}
	})
	//点击×删除标签
	$(document).on('click','#up-img .bq-t span a',function(){
		$(this).parent().remove();
	});
	//标签输入框获取标签时 显示推荐标签
	$('#up-img .bq-b>input').on('focus',function(){
		$('#up-img .texts>p').show();
	});
});

$(function(){
	$('#up-art .texts>p>span').on('click',function(){
		var len = $("#up-art .bq-t span").length;
		console.log(len);
		if(len > 2){
			alert('标签不能超过3个');
		}else{
			$('#up-art .bq-t').append($(this));
		}
	});

	$('#up-art .bq-b>input').on('keydown',function(e){
		var vals = $('#up-art .bq-b>input').val();
		var len = $("#up-art .bq-t span").length;
		var e = e || window.event;
		if(e.keyCode == 32 || e.keyCode == 13){
			if(len > 2){
				alert('标签不能超过3个'); 
			}else if($.trim(vals) != ''){
				var str = '<span>' + $.trim(vals) + '<a href="javascript:void(0)"></a></span>'
				$('#up-art .bq-t').append(str);
				$('#up-art .bq-b>input').val(null);
			}
		}else if(e.keyCode == 8 && vals === ''){
			$('#up-art .bq-t span:last-child').remove();
		}
	})
	$(document).on('click','#up-art .bq-t span a',function(){
		$(this).parent().remove();
	});
	$('#up-art .bq-b>input').on('focus',function(){
		$('#up-art .texts>p').show();
	});
});

$(function(){
	
	$('#up-vid .texts>p>span').on('click',function(){
		var len = $("#up-vid .bq-t span").length;
		console.log(len);
		if(len > 2){
			alert('标签不能超过3个');
		}else{
			$('#up-vid .bq-t').append($(this));
		}
	});
	$('#up-vid .bq-b>input').on('keydown',function(e){
		
		var vals = $('#up-vid .bq-b>input').val();
		var len = $("#up-vid .bq-t span").length;
		var e = e || window.event;
		if(e.keyCode == 32 || e.keyCode == 13){
			if(len > 2){
				alert('标签不能超过3个');
			}else if($.trim(vals) != ''){
				var str = '<span>' + $.trim(vals) + '<a href="javascript:void(0)"></a></span>'
				$('#up-vid .bq-t').append(str);
				$('#up-vid .bq-b>input').val(null);
			}
		}else if(e.keyCode == 8 && vals === ''){
			$('#up-vid .bq-t span:last-child').remove();
		}
	})

	$(document).on('click','#up-vid .bq-t span a',function(){
		$(this).parent().remove();
	});
	$('#up-vid .bq-b>input').on('focus',function(){
		$('#up-vid .texts>p').show();
	});
	
});



$(function(){
	$('#up>li>a').on('click',function(){
		var ind = $(this).parent().index();
			$('.upbg').show();
			$('#uploads').show();
			$('#uploads>div').eq(ind).show();

	});
	$('.upbg').on('click',function(){
		$(this).hide();
		$('#uploads').hide();
		$('#uploads>div').hide();
	});

	//  文件上传...
	//  $('#up-img .imgs').on('change',function(){
	// 	var objUrl = this.files[0] ;
 	//  console.log("objUrl = "+objUrl) ;
	// 	var file = $(this);
	// 	console.log(file);
	// });
})