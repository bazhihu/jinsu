; ~function () {

    var input = document.querySelector('#header input[type="search"]');
    var history = document.querySelector('.search-history');
    var list = document.querySelector('.nurses-list');

    var searchHistoryKey = 'search-nurses-history';

    var searchTimeout;

    if (input && history && list) {
        function onInput() {
            if (!input.value) {
                list.style.display = 'none';
                history.style.display = 'block';
                var keys = null, ul = history.querySelector('ul'), clear = history.querySelector('.clear');
                try {
                    keys = localStorage.getItem(searchHistoryKey).trim().split(',');
                } catch (error) {
                    keys = null;
                }
                ul.innerHTML = '';
                if (Array.isArray(keys) && keys.length) {
                    keys.forEach(function (k) {
                        var li = document.createElement('li');
                        li.innerHTML = '<a href="?q=' + encodeURIComponent(k) + '">' + k + '</a>';
                        ul.appendChild(li);
                    });
                    clear.style.display = 'block';
                } else {
                    clear.style.display = 'none';
                }
            } else {
                list.style.display = 'block';
                history.style.display = 'none';

                if (searchTimeout) {
                    clearTimeout(searchTimeout);
                }
                searchTimeout = setTimeout(search, 500);
            }
        }

        function search() {
            var searchUrl = '';
            // 这里添加搜索的逻辑
            $.ajax({
                data: {q: input.value} ,
                type: "GET",
                dataType: "json",
                url: cancelUrl,
                async:false,
                cache:false,
                crossDomain:true,
                timeout:30000,
                success: function(data){
                    if(data.code == 200){
                        list.querySelector('ul').innerHTML = result;
                        window.location.reload();
                    }
                },
                error: function(jqXHR, textStatus, errorThrown){
                    alert('网络超时!')
                }
            });
        }
        onInput();

        window.addEventListener('load', onInput);
        input.addEventListener('change', onInput);
        input.addEventListener('input', onInput);
        history.querySelector('.clear').addEventListener('click', function () {
            try {
                localStorage.removeItem(searchHistoryKey);
            } catch (error) {
            }
            history.querySelector('ul').innerHTML = '';
            this.style.display = 'none';
        });
    }
}();