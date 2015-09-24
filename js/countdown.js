/**
 * @author Yaohaixiao
 * @update 2012-09-20
 */
(function(){
	var getTimeImgHtml = function(num){
		var a = num.toString(10).split(''), l = a.length, r = [], i = 0;
		
		$(a).each(function(i, num){
			//r.push('<strong class="n' + a[i] + '"> ' + a[i] + ' </strong>');
			r.push('' + a[i] + '');
		});
		
		return r.join('');
	};
	
	// countdown 插件	
	$.fn.extend({
		countdown: function(config){
			var timer = null,   // 定时器
			    root = $(this), // 获得根节点
			    countBlocks = root.find('.countdown'), // 获得所有显示倒计时的 DOM 节点
                timeCount = null; // 显示计时内容函数

			timeCount = function(){
				// 如果有计时器，则释放资源
			    if (timer) {
				    clearTimeout(timer);
			    }
				
				// 循环（在每个 DOM 节点中显示计时数据）
				countBlocks.each(function(i, block){
					var curData = config[i].endTime, 
					    curIsStart = config[i].isStart, 
						curBlock = $(block),
						time = curData.split(' '), 
						dateVal = time[0].split('-'), 
						year = dateVal[0] * 1, 
						month = (dateVal[1] - 1) * 1, 
						date = dateVal[2] * 1, 
						hourVal = time[1].split(':'), 
						hour = hourVal[0] * 1, 
						minute = hourVal[1] * 1, 
						second = hourVal[2] * 1, 
						endTime = new Date(dateVal[0], month, date, hour, minute, second), 
						totalSeconds = (endTime - new Date()) / 1000, 
						countTime = null, 
						timeHTML = '', 
						days = 0, 
						hours = 0, 
						minutes = 0, 
						secounds = 0;
					
					// 活动结束
					if (parseInt(totalSeconds) <= 0) {
						curBlock.text('团购已经结束，可以继续购买!');
					}
					else {
					    // 活动开始
						// 计算剩余的时间
						days = parseInt(totalSeconds / 86400);
						hours = parseInt(totalSeconds % 86400 / 3600);
						minutes = parseInt((totalSeconds % 3600) / 60);
						seconds = parseInt((totalSeconds % 3600) % 60);
						
						// 时间为个位数时，显示 0 开头的两位数
						if (hours.toString().length === 1) {
							hours = '0' + hours;
						}
						if (minutes.toString().length === 1) {
							minutes = '0' + minutes;
						}
						if (seconds.toString().length === 1) {
							seconds = '0' + seconds;
						}
						
						// 获得剩余时间的 HTML 字符窜
						timeHTML = '<span>活动剩余时间：</span>' + getTimeImgHtml(days) + '<span>天</span>' + getTimeImgHtml(hours) + '<span>时</span>' + getTimeImgHtml(minutes) + '<span>分</span>' + getTimeImgHtml(seconds) + '<span>秒</span>';
						
						// （活动开始了）显示倒计时时间
						if (curIsStart) {
							curBlock.html(timeHTML);
						}
						else {
							// （活动未开始）显示提示信息
							curBlock.html('团购即将开始!');
						}
					}
				});
				
				// 创建计时器，每1秒刷新一次时间显示
				timer = setTimeout(timeCount, 1000);
			};
			
			// 执行计时函数
			timeCount();
		}
	});
})();