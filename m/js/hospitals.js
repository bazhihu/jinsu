function setValueByHash(value) {
    value && [].forEach.call(document.querySelector('.sites li'), function (li) {
        $(li)[sites.getAttribute('data-value') == value ? 'addClass' : 'removeClass']('selected');
    });
}

function fillList(data) {
    var s = '', sites = sites = document.querySelector('.sites'), className = '';
    className = ' class="recommends"';
    data.forEach(function (e) {
        s += '<li' + className + ' data-value="' + e.id + '">' + e.name + '</li>';
    });
    sites.innerHTML = s;
}

function onSearchChange() {
    getConfigs(function(configs){
        var hospitals = configs.hospitals;
        var value = $('#name').val();
        if(value && (value = value.trim())) {
            var search_array = new Array();
            $(hospitals).each(function (index, item) {
                var name = item.name;
                var id = item.id;
                var pinyin = item.pinyin;
                var search = name+pinyin;
                if (search.indexOf(value) >= 0) {
                    search_array.push({id:id,name:name});
                }
            });
            fillList(search_array?search_array : null);
        }else {
            fillList(hospitals?hospitals:null);
        }
    });
}

$('.search-sites input').on('input', onSearchChange);
$('.search-sites input').on('change', onSearchChange);

var siteScroller;
window.addEventListener('load', function () {
    onSearchChange();

    /* 如果要流畅的支持 Android 4.0 以前的浏览器，需要使用 iScroll 作为局部滚动方案。 */
    /* 否则，将使用浏览器的功能来实现滚动：浏览器支持 -webkit-overflow-scrolling 属性时将特别自然流畅；否则将滚动不自然 */
    //siteScroller = new iScroll(document.getElementById('site-scroller'));
});

window.addEventListener('load', onSearchChange);
$('.sites').delegate('li', 'click', function () {
    [].forEach.call(this.parentNode.children, function (li) {
        $(li)[li === this ? 'addClass' : 'removeClass']('selected');
    }, this);
    try {
        window.parent.$.dismissPopup({ value: this.getAttribute('data-value'), text: this.innerText || this.textContent });
    } catch (error) {
        window.history.back(1);
    }
});

$('#header .back').click(function (e) {
    var selected = document.querySelector('.sites .selected');
    try {
        window.parent.$.dismissPopup(selected ? { value: selected.getAttribute('data-value'), text: selected.innerText || selected.textContent } : null);
    } catch (error) {
        window.history.back(1);
    }
});