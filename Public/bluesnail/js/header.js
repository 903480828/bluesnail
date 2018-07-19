$(function(){

	$('.search input').on('focus',function(){
		$('.search input').css('border','1px solid #0066ff');
		$('.search button').css('background','#0066ff');
	});
	$('.search input').on('blur',function(){
		$('.search input').css('border','1px solid #ccc');
		$('.search button').css('background','#ccc');
	});
});