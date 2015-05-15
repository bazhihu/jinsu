function setValueByHash(value) {
    value && [].forEach.call(document.querySelector('.departments li'), function (li) {
        $(li)[sites.getAttribute('data-value') == value ? 'addClass' : 'removeClass']('selected');
    });
}

function fillList(data, append) {
    var s = '', sites = sites = document.querySelector('.departments'), className = ' class="recommends"';
    data.forEach(function (e) {
        s += '<li' + className + ' data-value="' + e.id + '">' + e.name + '</li>';
    });
    sites.innerHTML = s;
}

function onSearchChange() {
    getConfigs(function(configs){
        var departments = configs.departments;
        var value = $('#name').val();
        if(value && (value = value.trim())) {
            var search_array = new Array();
            $(departments).each(function (index, item) {
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
            fillList(departments?departments:null);
        }
    });
}

$('.search-sites input').on('input', onSearchChange);
$('.search-sites input').on('change', onSearchChange);
window.addEventListener('load', onSearchChange);
$('.departments').delegate('li', 'click', function () {
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
    var selected = document.querySelector('.departments .selected');
    try {
        window.parent.$.dismissPopup(selected ? { value: selected.getAttribute('data-value'), text: selected.innerText || selected.textContent } : null);
    } catch (error) {
        window.history.back(1);
    }
});