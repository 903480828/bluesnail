$(function(){

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
		console.log(boxHeight);
		console.log(maxBoxHeight);
	    $('#main').height(maxBoxHeight + 330);
	    
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