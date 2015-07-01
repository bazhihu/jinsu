; ~function () {
	var popupFrameId = 0, touchEnabled = navigator.msPointerEnabled || 'ontouchstart' in document;
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
			
			frame.className = 'popup-frame';
			frame.style.overflow = "visible";
		}
		frame.src = a.href;
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
	}).click(function (e) { e.preventDefault(); return false; });
	$('#patient-status-menuitem,#service-site-menuitem,#patient-menuitem,#disease-menuitem').on('change', function (e, tag) {
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
		if (start && end && !isNaN(start = Date.parse(start)) && !isNaN(end = Date.parse(end)) && end>=start) {
			d = Math.round((end - start) / 86400000) + 1 + '天';
		}
		//end.parentNode.querySelector('.title').innerHTML = ends ? '\u670d\u52a1\u7ed3\u675f\u65f6\u95f4\uff1a' : '';
		days['value' in days ? 'value' : 'innerHTML'] = d;
		//$(end)[ends ? 'removeClass' : 'addClass']('empty');
	});
	window.addEventListener('load', function () { $('#care-start').trigger('change'); });
    var $options = $('.filter-options');
    var header = document.getElementById('header');
    var filters = document.querySelector('.nurses-filters');
    var touchMoveEnabled = 1;
    function preventDefault(e) {
        e.preventDefault();
    }
    function setTouchMoveEnabled(enabled) {
        if (enabled) {
            header.removeEventListener('touchmove', preventDefault);
        } else if (touchMoveEnabled) {
            touchMoveEnabled = 1;
            header.addEventListener('touchmove', preventDefault);
        }
    }
    $('#servicetime-menuitem').tap(function () {
        var cid = this.htmlFor, $option = $('#' + cid), t = this, $this = $(this);
        if ($this.hasClass('filter-label-selected')) {
            $option.removeClass('filter-options-expanded');
            $this.removeClass('filter-label-selected');
            setTouchMoveEnabled(true);
            $('#jdate-btn-remove').trigger('click');
        } else {
            $options.forEach(function (options) {
                $(options)[cid === options.id ? 'addClass' : 'removeClass']('filter-options-expanded');
            });
            //$labels.forEach(function (label) {
            //	$(label)[label === t ? 'addClass' : 'removeClass']('filter-label-selected');
            //});
            $this.addClass('filter-label-selected');
            setTouchMoveEnabled(false);
            console.log('a');
            $('#jdate-btn-remove').trigger('click');
            $option.find('label.selected input').trigger('click');
            console.log($option);
        }
    });

    $('input[type="date"]').jdate(false).forEach(function (input) {
        input.addEventListener('tap', function (e) {
            var parent = this.parentNode;
            e.preventDefault();

            [].forEach.call(parent.parentNode.children, function (label) {
                $(label)[label === parent ? 'addClass' : 'removeClass']('selected');
            });
            return false;
        });
        input.readOnly = true;
        // 修改 type 解决 Android QQ 浏览器问题。
        input.type = 'button';
    });

    document.getElementById('service-time') && document.getElementById('service-time').addEventListener('submit', function (e) {
        e.preventDefault();
        var start = new Date(Date.parse(document.getElementById('start-time').value));
        var end = new Date(Date.parse(document.getElementById('end-time').value));
        if (end < start) {
            var today = new Date().format("yyyy-MM-dd");
            dateOne = document.getElementById('start-time').value;
            dateTwo = document.getElementById('end-time').value;
            if ((dateOne > dateTwo)) {
                alert("服务开始时间不能大于服务结束时间！");
                return false;
            }
            if ((dateOne < today)) {
                alert("服务开始时间不能小于当天！");
                return false;
            }

            if ((dateTwo < today)) {
                alert("服务结束时间不能小于当天！");
                return false;
            }

            if (dateOne == dateTwo) {
                alert("服务开始时间和服务结束时间不能为同一天！");
                return false;
            }
        }
        document.getElementById('start').value=document.getElementById('start-time').value;
        document.getElementById('end').value=document.getElementById('end-time').value;
        document.querySelector('#servicetime-menuitem .value').innerHTML = (start.getMonth() + 1) + '\u6708' + start.getDate() + '\u65e5 - ' + (end.getMonth() + 1) + '\u6708' + end.getDate() + '\u65e5 <em class="nurses-days">\u5171' + ((end - start) / 86400000 + 1) + '\u5929</em>';
        $('#jdate-btn-remove').trigger('click');
        $('#servicetime-menuitem').trigger('tap');
    });
}();