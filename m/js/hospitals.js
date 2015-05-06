getConfigs(function(configs) {
    //常驻医院
    var bodyHtml = template('bodyTemplate', configs);
    $('#body').html(bodyHtml);
});

function setValueByHash(value) {
    value && [].forEach.call(document.querySelector('.sites li'), function (li) {
        $(li)[sites.getAttribute('data-value') == value ? 'addClass' : 'removeClass']('selected');
    });
}

function fillList(data, append) {
    console.log(append);
    var s = '', sites = document.querySelector('.sites'), className = '';
    if (!data) {
        var configs = getConfigs(function(configs){});
        data = configs.hospitals;
        className = ' class="recommends"';
    }
    data.forEach(function (e) {
        s += '<li' + className + ' data-value="' + e.id + '">' + e.name + '</li>';
    });
    if (append) {
        sites.insertAdjacentHTML ? sites.insertAdjacentHTML('beforeEnd', s) : (sites.innerHTML += s);
    } else {
        sites.innerHTML = s;
    }
}
function onSearchChange() {
    var configs = getConfigs(function(configs){});
    var hospitals = configs.hospitals;
    var value = this.value;

    if(value && (value = value.trim())) {
        var search_array = new Array();
        $(hospitals).each(function (index, item) {
            var name = item.name;
            var id = item.id;
            var pinyin = item.pinyin;
            var search = name+pinyin;
            if (search.indexOf(value) >= 0) {
                search_array ={"id":"'+id+'","name":"'+name+'"};
            }
        });
        fillList(Array.isArray(search_array) && search_array.length ? search_array : null);
    }else {
        fillList();
    }
}
$('.search-sites input').on('input', onSearchChange);
$('.search-sites input').on('change', onSearchChange);
window.addEventListener('load', onSearchChange);
$('.sites').delegate('li', 'click', function () {
    [].forEach.call(this.parentNode.children, function (li) {
        $(li)[li === this ? 'addClass' : 'removeClass']('selected');
    }, this);
    console.log(this);
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