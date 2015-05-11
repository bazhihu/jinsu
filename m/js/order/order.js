var type = getUrlQueryString('type'),
    userInfo = getStatus(),
    orderCreate = orderUrl+'?access-token='+userInfo.token;
getConfigs(function(configs){
    var start_min= new Date().format("yyyy-MM-dd");
    var start_max = addMonth(new Date(),3);
    var end_min = addDay(new Date(),10);
    var end_max = addMonth(addDay(new Date(),10),3);
    var data = {
        type:type,
        mobile:userInfo.name,
        start_min:start_min,
        start_max:start_max,
        end_min:end_min,
        end_max:end_max,
        worker_levels:configs.worker_levels
    };
    var bodyHtml = template('bodyTemplate', data);
    $('#body').html(bodyHtml);
});

; ~function () {
    //立即下单
    $("#orderCreate").on('click', function () {
        var formData = $("form").serializeArray();
        var str = '';
        var des ='';
        $.each(formData, function(i, field){
            str = str+field.value+"#";
        });

        if(!$("#mobile").val())
            des = "请填写联系方式！";
        else if(!$("#care-start").val())
            des = "请选择服务开始时间！";
        else if(!$("#care-end").val())
            des = "请选择服务结束时间！";
        else if(!$("#hospital_id").val())
            des = "请选择服务医院！";
        else if(!$("#department_id").val())
            des = "请选择服务科室！";

        if(des){
            alert(des);
            return false;
        }else{
            setCookie('orderData',str);
            if(type=='select'){
                location.href="nursesList.html";
            }else{
                location.href="orderConfirm.html?type="+type;
            }
        }
    });



    var popupFrameId = 0, touchEnabled = navigator.msPointerEnabled || 'touchstart' in document;
	touchEnabled && $('a[target="popup"]').click(function (e) {
		e.preventDefault();
		return false;
	});

	$('a[target="popup"]')[touchEnabled ? 'tap' : 'click'](function (e) {
		e.preventDefault();
		var a = this, frame;
		if (a.popupFrameId) {
			frame = document.getElementById('popup-frame-' + a.popupFrameId);
		} else {
			a.popupFrameId = ++popupFrameId;
			frame = document.createElement('iframe');
			frame.id = 'popup-frame-' + popupFrameId;
			frame.src = a.href;
			frame.className = 'popup-frame';
		}
		$(frame).popup('right', false, false);
		$(frame).one('load', function () {
			frame.contentWindow.setValueByHash && frame.contentWindow.setValueByHash(a.querySelector('input[type="hidden"]').value);
		});
		try { frame.contentWindow.setValueByHash && frame.contentWindow.setValueByHash(a.querySelector('input[type="hidden"]').value); } catch (error) { }
		document.body.style.overflow = 'hidden';
		$(frame).one('dismiss', function (e, tag) {
			document.body.style.overflow = 'auto';
			document.body.style.removeProperty('overflow');
			tag && (a.querySelector('input[type="hidden"]').value = tag.value || '');
			$(a).trigger('change', tag);
		});
		return false;
	});
	$('#patient-status-menuitem,#hospitals-menuitem,#departments-menuitem').on('change', function (e, tag) {
		if (tag) {
			var value = this.querySelector('.value');
			value.innerHTML = tag.text || '';
			if (this.id === 'patient-status-menuitem') {
				var add = tag.value == 2 ? 'addClass' : 'removeClass';
				$(this)[add]('additional');
				$('.care-levels')[add]('care-additional');
			}
		}
	});
	$('.menuitem input,.menuitem select').on('change', function () {
		$(this)[this.value ? 'removeClass' : 'addClass']('empty');
	});
	var days = document.getElementById('care-days');
	days && $('#care-start,#care-end').on('change', function () {
		var start = document.getElementById('care-start').value;
		var end = document.getElementById('care-end').value;
		var d = '';
		if (start && end) {
			//d = Math.round((end - start) / 86400000) + 1 + '天';
            d = getOrderCycle(start,end);
		}
		//end.parentNode.querySelector('.title').innerHTML = ends ? '\u670d\u52a1\u7ed3\u675f\u65f6\u95f4\uff1a' : '';
		days['value' in days ? 'value' : 'innerHTML'] = d;
        $('#days').val(days);
		//$(end)[ends ? 'removeClass' : 'addClass']('empty');
	});
	window.addEventListener('load', function () { $('#care-start').trigger('change'); });
}();