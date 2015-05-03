; ~function (initSelector) {

	function fromSelect(select) {
		var container = document.createElement('div'), s = '<div class="wheel-selector-container">';
		if (select.title) {
			s += '<h4 class="wheel-selector-title">' + select.title + '</h4>';
		}
		s += '<div class="wheel-selector-viewport"><div class="wheel-selector-scroller swiper-container"><ul class="wheel-selector-list swiper-wrapper">';
		[].forEach.call(select.options, function (option) {
			s += '<li class="swiper-slide"><div class="wheel-selector-option" data-value="' + option.value + '">' + (option.title ? ('<em class="wheel-selector-option-title">' + option.title + '</em>') : '') + '<div class="wheel-selector-option-text">' + option.text + '</div></div></li>';
		});
		s += '</ul></div></div>';
		s += '<span role="button" class="wheel-selector-cancel">\u53d6\u6d88</span><span role="button" class="wheel-selector-ok">\u786e\u5b9a</span></div>';
		container.innerHTML = s;
		container.className = 'wheel-selector';
		container.appendChild(select);
		container.querySelector('.wheel-selector-cancel').addEventListener('tap', $.dismissPopup);
		Object.defineProperty(container, 'value', {
			get: function () {
				return this.querySelector('select').value;
			},
			set: function () {
				
			}
		});
		$(container.querySelector('.wheel-selector-cancel')).tap($.dismissPopup);
		$(container.querySelector('.wheel-selector-ok')).tap( function () {
			$.dismissPopup();
			var value = (this.querySelector('.swiper-slide-active') || this.querySelector('.wheel-selector-option')).getAttribute('data-value'), hasSelected;
			var select = this.querySelector('select');
			[].every(select.options, function (option) {
				if (hasSelected || option.value != value) {
					option.selected = false;
				} else {
					option.selected = true;
				}
			});
			$(select).trigger('change');
		});
		document.body.appendChild(container);
		var scroller;
		select.addEventListener('focus', function () {
			$(this.parentNode).popup();
		});

		select.id && $('label[for="' + select.id + '"]').tap(function () {
			$('#' + this.htmlFor).parent().popup();
		});
		container.addEventListener('popup', function (e) {
			setTimeout(function () {
				//window.scroller = scroller = new iScroll(container.querySelector('.swiper-container'), {
				//	snap: 'li.swiper-slide',
				//	hideScrollbar: false,
				//	fadeScrollbar: false,
				//	hScroll: false,
				//	vScroll: true
				//});
				scroller = new Swiper(container.querySelector('.swiper-container'), {
					direction: 'vertical',
					freeMode: false,
					freeModeMomentumRatio: 5
				});
			}, 0);
		});
		container.addEventListener('dismiss', function () {
			scroller && scroller.destroy(false);
		});
		document.body.appendChild(container);
	}
	
	initSelector && window.addEventListener('load', function () {
		[].forEach.call(document.querySelectorAll(initSelector), fromSelect);
	});
}('select.wheel-selector');