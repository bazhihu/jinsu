; ~function () {

	var $labels = $('.filter-label');
	var $options = $('.filter-options');
	var header = document.getElementById('header');
	var filters = document.querySelector('.nurses-filters');
	var touchMoveEnabled = 1;
	var afterTapTimeout = 0;
	function preventDefault(e) {
		e.preventDefault();
	}
	function afterTap(t) {
		if (afterTapTimeout) {
			clearTimeout(afterTapTimeout);
		}
		document.body.style.pointerEvents = 'none';
		t = t - 0;
		afterTapTimeout = setTimeout(function () {
			document.body.style.pointerEvents = '';
			document.body.style.removeProperty('pointer-events');
			afterTapTimeout = 0;
		}, t || 500);
	}
	function setTouchMoveEnabled(enabled) {
		if (enabled) {
			header && header.removeEventListener('touchmove', preventDefault);
			filters && filters.removeEventListener('touchmove', preventDefault);
		} else if (touchMoveEnabled) {
			touchMoveEnabled = 1;
			header && header.addEventListener('touchmove', preventDefault);
			filters && filters.addEventListener('touchmove', preventDefault);
		}
	}
	$('#header .back').click(function (e) {
		var $expanded = $('.filter-options-expanded');
		if ($expanded.length) {
			e.preventDefault();
			$expanded.forEach(function (options) {
				$(options).removeClass('filter-options-expanded');
			});
			$('.filter-label-selected').forEach(function (label) {
				$(label).removeClass('filter-label-selected');
			});
			return false;
		}
	});
	$labels.live(CLICK,function () {
		var cid = this.htmlFor, $option = $('#' + cid), t = this, $this = $(this);
		afterTap();
		if ($this.hasClass('filter-label-selected')) {
			$option.removeClass('filter-options-expanded');
			$this.removeClass('filter-label-selected');
			setTouchMoveEnabled(true);
			if (cid === 'service-time') {
				$('#jdate-btn-remove').trigger('click');
			}
		} else {
			$options.forEach(function (options) {
				$(options)[cid === options.id ? 'addClass' : 'removeClass']('filter-options-expanded');
			});
			$labels.forEach(function (label) {
				$(label)[label === t ? 'addClass' : 'removeClass']('filter-label-selected');
			});
			setTouchMoveEnabled(false);
			$('#jdate-btn-remove').trigger('click');
			if ($option.hasClass('filter-category')) {
				var category = $option[0].querySelector('.category').parentNode, subcategory = $option[0].querySelector('.subcategory-selected');
				if (category) {
					if (!category.scroller || !category.scroller.refresh) {
						category.scroller = new iScroll(category);
					} else {
						category.scroller.refresh();
						subcategory.scroller.scrollTo(0, 0);
					}
				}
				if (subcategory) {
					if (!subcategory.scroller || !subcategory.scroller.refresh) {
						subcategory.scroller = new iScroll(subcategory);
					} else {
						subcategory.scroller.refresh();
						subcategory.scroller.scrollTo(0, 0);
					}
				}
			} else if (cid === 'service-time') {
				$option.find('label.selected input').trigger('click');
			}
		}
	});
	$('.filter-category .category li').live(CLICK,function () {
		var id = this.getAttribute('data-id'), t = this, filter = this.parentNode.parentNode.parentNode, subcategory;
		[].forEach.call(this.parentNode.children, function (option) {
			$(option)[option === t ? 'addClass' : 'removeClass']('selected');
		});
		[].forEach.call(filter.querySelectorAll('.subcategory'), function (sub) {
			$(sub)[sub.getAttribute('data-category') === id ? 'addClass' : 'removeClass']('subcategory-selected');
		});
		if (subcategory = filter.querySelector('.subcategory-selected')) {
			if (!subcategory.scroller || !subcategory.scroller.refresh) {
				subcategory.scroller = new iScroll(subcategory);
			} else {
				subcategory.scroller.refresh();
				subcategory.scroller.scrollTo(0, 0);
			}
		}
	});
	$('.filter-category .ok').forEach(function (ok) {
		var selected = ok.parentNode.querySelector('.filter-category .subcategory li[data-value].selected');

		$(ok)[selected ? 'removeClass' : 'addClass']('ok-disabled');
	});
	$('.filter-category .subcategory li[data-value]').live(CLICK,function () {
		var items = this.parentNode.parentNode.parentNode.querySelectorAll('.subcategory li[data-value]');
		var t = this;
		[].forEach.call(items, function (item) {
			$(item)[item === t ? 'addClass' : 'removeClass']('selected');
		});
		$(this.parentNode.parentNode.parentNode.querySelector('.ok')).removeClass('ok-disabled');
	});
	$('.filter-category .ok').live(CLICK,function () {
		var selected = this.parentNode.querySelector('.subcategory li[data-value].selected');
		if (selected) {
			afterTap();
			$(this.parentNode).removeClass('filter-options-expanded');
			$('*[for="' + this.parentNode.id + '"]').removeClass('filter-label-selected');
			$('*[for="' + this.parentNode.id + '"] .value').html(selected.innerHTML);
			$('*[for="' + this.parentNode.id + '"] input').val(selected.getAttribute('data-value'));
		} else {
			$(this).addClass('ok-disabled');
		}
	});


	function getSelectedOption(select) {
		selectOption = select.options[0];
		[].every.call(select.options, function (option) {
			if (option.selected) {
				selectOption = option;
				return false;
			}
			return true;
		});
		return selectOption;
	}
	function initSelector(select) {
		var selectOption, value;
		if ((selectOption = select.options[0]) && selectOption.value === '') {
			value = document.createElement('i');
			selectOption = getSelectedOption(select);
			value.innerText = value.textContent = selectOption.text;

			value.className = (selectOption.value === '' ? 'empty ' : '') + 'value right-selector-placeholder';
			select.parentNode.insertBefore(value, select);
			select.addEventListener('change', function () {
				var selectOption = getSelectedOption(this);
				var placeholder = this.parentNode.querySelector('.right-selector-placeholder');
				placeholder.innerText = placeholder.textContent = selectOption.text;
				placeholder.className = (selectOption.value === '' ? 'empty ' : '') + 'value right-selector-placeholder';
			});
		}
	}
	$('select.right-selector').forEach(function (select) {
		initSelector(select);
	});
}();