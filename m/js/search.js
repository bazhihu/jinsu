; ~function () {

    var input = document.querySelector('#header input[type="search"]');
    var history = document.querySelector('.search-history');
    var list = document.querySelector('.nurses-list');

    var searchHistoryKey = 'search-nurses-history';

    var searchTimeout;

    var q = getUrlQueryString('q');
    console.log(q);

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
            var searchUrl = workerUrl_v2+'?name='+input.value;
            // 这里添加搜索的逻辑
console.log(input.value);
            $.ajax({
                data: {q: input.value} ,
                type: "GET",
                dataType: "json",
                url: searchUrl,
                async:false,
                cache:false,
                crossDomain:true,
                timeout:30000,
                success: function(data){
                    if(data.code == 200){
                        var items = data.data.items,
                            length = items.length,
                            list = $('#list');
                        list.empty();
                        if(length>0){
                            for(var i = 0;i<length;i++){
                                var result = '<li>' +
                                    '<a href="./nursesDetail.html?worker_id='+items[i]['worker_id']+'&start_time=0&end_time=0&in_service='+items[i]['in_service']+'">' +
                                    '<div class="nurses-photo" style="background-image: url('+items[i]['pic']+')"></div>' +
                                    '<div class="nurses-detail">' +
                                    '<span class="nurses-price"><em>'+items[i]['price']+'</em>元/天</span>';
                                if(items[i].star>4 || !items[i].star){
                                    result+='<span class="nurses-rate">★★★★★</span>';
                                } else if(items[i].star>3){
                                    result+='<span class="nurses-rate">★★★★</span>';
                                }else if(items[i].star>2){
                                    result+='<span class="nurses-rate">★★★</span>';
                                }else if(items[i].star>1){
                                    result+='<span class="nurses-rate">★★</span>';
                                }else if(items[i].star>0){
                                    result+='<span class="nurses-rate">★</span>';
                                }
                                result +=
                                    '<h4 class="nurses-name">'+items[i]['name']+'</h4>' +
                                    '<p class="nurses-intro">'+ages(items[i].birth)+'岁 | '+items[i].native_province+' | '+ages(items[i].start_work)+'年从业经验</p>' +
                                    '<p class="nurses-reserve">'+items[i].level_name;
                                if(items[i].in_service)
                                    result+='<span class="status-busy nurses-status">服务中</span>';
                                else
                                    result+='<span class="nurses-status">空闲</span>';

                                result+='</div></a></li>';
                                list.append(result);
                            }
                        }else{
                            var result = '<div class="nurses-list-none nurses-list"></div>';
                            $('#list').append(result);
                        }
                        /*list.querySelector('ul').innerHTML = result;*/
                        //window.location.reload();
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
    /**
     * 计算年龄
     * @param str
     * @returns {*}
     */
    function ages(str)
    {
        var   r   =   str.match(/^(\d{1,4})(-|\/)(\d{1,2})\2(\d{1,2})$/);
        if(r==null)return   false;
        var   d=new Date(r[1],r[3]-1, r[4]);
        if (d.getFullYear()==r[1]&&(d.getMonth()+1)==r[3]&&d.getDate()==r[4])
        {
            var   y=new Date().getFullYear();
            var years =y-r[1];
            if(years<1)
                years = 1;
            return years;
        }
        return(false);
    }
}();