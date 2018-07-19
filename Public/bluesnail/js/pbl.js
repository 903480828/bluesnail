$(function(){
	$('.btnjz').on('click',function(){
		var str = '';
		boxlis = $('.box').length;
		var num = 8;
		$.ajax({
			url:'__APP__/Home/Index/pbl',
			type:'post',
			data:num,
			success:function(msg){
				console.log(msg);
			},
			error:function(err){
				console.log(err);
			}
		});
		
		//ajax请求的数据
		var imgs = [{'img':'img_01.png'},{'img':'img_02.png'},{'img':'img_03.png'},{'img':'img_04.png'},{'img':'img_05.png'},{'img':'img_06.png'},{'img':'img_07.png'},{'img':'img_08.png'}];

		for( var i=0; i<imgs.length; i++){
			str += '<li class="box"> <a href="###"><img src="./images/' + imgs[i].img + '" alt="作品"></a> <div> <h5><a href="###">手绘技巧分享</a></h5> <div class="x-info"> <p><span>手绘教程</span><span>小视频</span></p> <p><span>2017/11/25</span></p> </div> </div> </li>'
		}
		$('#main').append(str);
		$('.box>a>img').load(function(){
			pul();
		});
	});
	
	$('.box>a>img').load(function(){
		pul();
	});
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
	    $('#main').height(maxBoxHeight + 50);
	    
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
})