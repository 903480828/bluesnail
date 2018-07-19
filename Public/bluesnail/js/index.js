$(function(){
	var num = 1;
	var timer = setInterval(lb,4000);
	$('.banner').on('mouseover',function(){
		clearInterval(timer)
	});
	
	$('.banner').on('mouseout',function(){
		timer = setInterval(lb,4000);
	});
	
	$('.banner_btn li').on('mouseover',function(){
		num = $(this).index();
		lb(num);
	});

	function lb(n=num){
		$('.banner_lb').animate({left:-100*n + '%'},1500,function(){
			num++
			//console.log(num);
			if(num == 3){
				num = 0;
			}
		});
		$('.banner_btn li').removeClass('on');
		$('.banner_btn li').eq(num).addClass('on');
	}
});