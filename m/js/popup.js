; ~function ($) {
	var container, popuped = [], source = [], globalDismissOnTap, popupTimeout;
	var fromDir = 'top,bottom,left,right'.split(',');
	$.fn.popup = function (from, dismissOnTap, restoreOnDismiss) {
		popupTimeout && clearTimeout(popupTimeout);
		if (!container) {
			container = document.createElement('div');
			container.className = 'popup';
			container.addEventListener('touchmove', function (e) {
				e.preventDefault();
			});
			container.addEventListener('MSPointerMove', function (e) {
				e.preventDefault();
			});
			document.body.appendChild(container);

			container.addEventListener('tap', function (e) {
				if (globalDismissOnTap) {
					$.dismissPopup();
				}
			});
		} else {
		}
		globalDismissOnTap = !!dismissOnTap;
		var $container = $(container);
		popuped.forEach(function (element, i) {
			source[i] = undefined;
			popuped[i] = undefined;
		});
		popuped.length = 0;
		popuped.length = 0;
		popuped = new Array(this.length);
		source = new Array(this.length);
		this.forEach(function (element, i) {
			popuped[i] = element;
			source[i] = {
				parent: element.parentNode,
				before: element.nextSibling,
				restoreOnDismiss: restoreOnDismiss === false ? false : true
			};
			element.parentNode !== container && container.appendChild(element);
			$(element).trigger('popup');
		});
		container.style.display = 'block';
		document.body.style.pointerEvents = 'none';
		container.className = 'popup popup-from-' + (fromDir.indexOf(from) < 0 ? 'bottom' : from);
		setTimeout(function () {
			$(container).addClass('popup-visible');
		}, 10);
		popupTimeout = setTimeout(function () {
			popupTimeout = 0;
			document.body.style.pointerEvents = '';
			document.body.style.removeProperty('pointer-events');
		}, 500);
		return this;
	};

	$.dismissPopup = function (tag) {
        popupTimeout && clearTimeout(popupTimeout);
        var $container = $(container);
        $container.removeClass('popup-visible');
        document.body.style.pointerEvents = 'none';
        popupTimeout = setTimeout(function () {
            popupTimeout = 0;
            container.style.display = 'none';
            document.body.style.pointerEvents = '';
            document.body.style.removeProperty('pointer-events');
            popuped.forEach(function (k, i) {
                if (source[i].restoreOnDismiss && source[i].parent && source[i].parent.insertBefore) {
                    source[i].before && source[i].before.parentNode && source[i].before.parentNode === source[i].parent ?
                        source[i].parent.insertBefore(k, source[i].before) :
                        source[i].parent.appendChild(k);
                }
                source[i] = undefined;
                popuped[i] = undefined;
            });
            popuped.length = 0;
            popuped.length = 0;
        }, 500);
        popuped.forEach(function (k) {
            $(k).trigger('dismiss', tag);
        });
    };
}($);