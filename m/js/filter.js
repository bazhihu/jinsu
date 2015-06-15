; ~function () {
    //城市
    var city_id = getUrlQueryString('city_id');
    if(!city_id) city_id=110100;

    var time_url = "?city_id="+city_id;
    var select_url = "?city_id="+city_id;

    //开始时间
    var start_time = getUrlQueryString('start_time');
    if(start_time) {
        $('.nurses-filter-tips').html("服务时间:"+start_time);
        select_url+="&start_time="+start_time;
    }

    //结束时间
    var end_time = getUrlQueryString('end_time');
    if(end_time) {
        $('.nurses-filter-tips').html("服务时间:"+start_time);
        select_url+="&end_time="+end_time;
    }

    //性别
    var gender = getUrlQueryString('gender');
    if(gender){
        time_url+="&gender="+gender;
    }

    //籍贯
    var native_province = getUrlQueryString('native_province');
    if(native_province){
        time_url+="&native_province="+native_province;
    }

    //护工等级
    var worker_level = getUrlQueryString('worker_level');
    if(worker_level){
        time_url+="&worker_level="+worker_level;
    }

    //排序
    var sort = getUrlQueryString('sort');
    if(sort){
        time_url+="&sort="+sort;
        select_url+="&sort="+sort;
    }

    var $labels = $('.filter-label');
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
			filters.removeEventListener('touchmove', preventDefault);
		} else if (touchMoveEnabled) {
			touchMoveEnabled = 1;
			header.addEventListener('touchmove', preventDefault);
			filters.addEventListener('touchmove', preventDefault);
		}
	}

	$labels.tap(function () {
		var cid = this.htmlFor, $option = $('#' + cid), t = this, $this = $(this);
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
				var category = $option[0].querySelector('.category'), subcategory = $option[0].querySelector('.subcategory-selected');
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
	$('.filter-category .category li').tap(function () {
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

	function getMoreFilters() {
		var filters = {};
		$('#more .subcategory li.selected').forEach(function (option) {
			var name = option.parentNode.parentNode.getAttribute('data-category');
			var value = option.getAttribute('data-value');
			if (value) {
				filters[name] = value;
			}
		});
		return filters;
	}
	var originalFilters = getMoreFilters();
    $('#more .subcategory li').live(CLICK,function(){
        var items = this.parentNode.children;
        var t = this;
        [].forEach.call(items, function (item) {
            $(item)[item === t ? 'addClass' : 'removeClass']('selected');
        });
    });

	document.querySelector('#more .operations').addEventListener('touchmove', preventDefault);
	$('#more .reset-button').tap(function () {
		$('#more .subcategory li').forEach(function (option) {
			var name = option.parentNode.parentNode.getAttribute('data-category');
			var value = option.getAttribute('data-value');
			$(option)[originalFilters[name] === value ? 'addClass' : 'removeClass']('selected');
		});
	});
	$('#more .submit-button').click(function () {
		var parameters = [], filters = getMoreFilters();
		for (var k in filters) {
			parameters.push(k + '=' + filters[k]);
		}
		parameters = parameters.join('&');

		// TODO 将参数拼接到适当的 URL 后进行跳转。
        location.href = select_url+"&"+parameters;
	});

    $('#service-time input[type="date"]').click(function(e){alert(1);e.preventDefault();return false;});
    $('#service-time input[type="date"]').jdate(false).forEach(function (input) {
        alert(2);
		input.addEventListener('focus', function () { this.blur(); });
		input.addEventListener('tap', function () {
			var parent = this.parentNode;
			[].forEach.call(parent.parentNode.children, function (label) {
				$(label)[label === parent ? 'addClass' : 'removeClass']('selected');
			});
		});
		input.readOnly = true;
	});


	document.getElementById('service-time').addEventListener('submit', function (e) {
		e.preventDefault();
		var start = new Date(Date.parse(document.getElementById('start-time').value));
		var end = new Date(Date.parse(document.getElementById('end-time').value));
		//document.querySelector('.nurses-filter-tips').innerHTML = '\u670d\u52a1\u65f6\u95f4\uff1a' + start.getFullYear() + '\u5e74' + (start.getMonth() + 1) + '\u6708' + start.getDate() + '\u65e5 - ' + end.getFullYear() + '\u5e74' + (end.getMonth() + 1) + '\u6708' + end.getDate() + '\u65e5';
		$('#jdate-btn-remove').trigger('click');
		$('.nurses-filters label[for="service-time"]').trigger('tap');

        if(start && end) {
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

        location.href = time_url+"&start_time="+document.getElementById('start-time').value+"&end_time="+document.getElementById('end-time').value;
	});

	try {
		// 判断是否已经提示过
		if (localStorage.getItem('filter-wiz') !== 'closed') {
			var cityWiz = document.createElement('div'), timeWiz = document.createElement('div');
			cityWiz.className = 'filter-wiz-visible filter-wiz-city filter-wiz';
			timeWiz.className = 'filter-wiz-time filter-wiz';
			document.body.appendChild(timeWiz);
			document.body.appendChild(cityWiz);
			timeWiz.addEventListener('touchmove', preventDefault);
			cityWiz.addEventListener('touchmove', preventDefault);
			$(cityWiz).tap(function () {
				$(cityWiz).removeClass('filter-wiz-visible');
				$(timeWiz).addClass('filter-wiz-visible');
				setTimeout(function () {
					document.body.removeChild(cityWiz);
				}, 500);
			});
			$(timeWiz).tap(function () {
				$(timeWiz).removeClass('filter-wiz-visible');
				setTimeout(function () {
					document.body.removeChild(timeWiz);
				}, 500);
				// 使用本地存储设置已经提示过了
				localStorage.setItem('filter-wiz', 'closed');
			});
		}
	} catch (error) { }
}();

