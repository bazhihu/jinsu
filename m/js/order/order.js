; $(function () {
    var type = getUrlQueryString('type'),
        userInfo = getStatus(),
        orderCreate = orderUrl+'?access-token='+userInfo.token;

    if(userInfo.name){
        $("#login").show();
        $('#nologin').hide();
        $('#mobile').val(userInfo.name);
        $('#has_mobile').html(userInfo.name);
    }

    var popupFrameId = 0, touchEnabled = navigator.msPointerEnabled || 'touchstart' in document;
	touchEnabled && $('a[target="popup"]').click(function (e) {
		e.preventDefault();
		return false;
	});

    $('a[target="popup"]')['click'](function (e){
		e.preventDefault();
		var a = this, frame;
        a.popupFrameId = ++popupFrameId;
        frame = document.createElement('iframe');
        frame.id = 'popup-frame-' + popupFrameId;
        frame.className = 'popup-frame';
        frame.src = a.href;
		$(frame).popup('right', false, false);
		$(frame).one('load', function () {
			frame.contentWindow.setValueByHash && frame.contentWindow.setValueByHash(a.querySelector('input[type="hidden"]').value);
		});

		try {
            frame.contentWindow.setValueByHash && frame.contentWindow.setValueByHash(a.querySelector('input[type="hidden"]').value);
        }catch (error) {}

		document.body.style.overflow = 'hidden';
		$(frame).one('dismiss', function (e, tag) {
			document.body.style.overflow = 'auto';
			document.body.style.removeProperty('overflow');
            console.log(tag)
			tag && (a.querySelector('input[type="hidden"]').value = tag.value || '');
			$(a).trigger('change', tag);
		}).click(function (e) { e.preventDefault(); return false; });
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
    //alert("days:"+days);
	days && $('#care-start,#care-end').on('change', function () {
		var start = document.getElementById('care-start').value;
		var end = document.getElementById('care-end').value;
       // alert("start:"+start+":end"+end);
		var d = '';
		if (start && end) {
            d = getOrderCycle(start,end);
		}
        //alert("d:"+d);
		days['value' in days ? 'value' : 'innerHTML'] = d;
        $('#days').val(days);
	});
	window.addEventListener('load', function () { $('#care-start').trigger('change'); });

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

        var start = $('#care-start').val(),
            end = $('#care-end').val(),
            today = new Date().format("yyyy-MM-dd");

        if(start && end){
            var dateOne   = new Date(start.replace(/-/g, "/")),
                dateTwo   = new Date(end.replace(/-/g, "/"));
                today   = new Date(today.replace(/-/g, "/"));
            dateOne   = dateOne.getTime();
            dateTwo   = dateTwo.getTime();
            today     = today.getTime();

            if((dateOne>dateTwo)){
                alert("服务开始时间不能大于服务结束时间！");
                return false;
            }
            if((dateOne<today)){
                alert("服务开始时间不能小于当天！");
                return false;
            }

            if((dateTwo<today)){
                alert("服务结束时间不能小于当天！");
                return false;
            }

            if(dateOne==$("#care-end").val()){
                alert("服务开始时间和服务结束时间不能为同一天！");
                return false;
            }
        }

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
});