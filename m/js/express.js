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
}();