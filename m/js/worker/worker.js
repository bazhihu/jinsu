function getUrlQueryString(name) {
    var reg = new RegExp("(^|&)" + name + "=([^&]*)(&|$)", "i");
    var r = window.location.search.substr(1).match(reg);
    if (r != null) return unescape(r[2]); return null;
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

/**
 * 护工列表
 */
function get_workelist() {
    ~function () {
        var list = document.querySelector('.nurses-list'), loading = document.querySelector('.loading'), isLoading = 0;
        function load() {
            if (loading && !isLoading) {
                var bounds = loading.getBoundingClientRect();
                if (bounds.bottom < document.documentElement.clientHeight + 200) {
                    isLoading = 1;
                    window.removeEventListener('scroll', load);
                    var pageNum=1;
                    if(list.children.length){
                        pageNum =Math.ceil(list.children.length/10)+1;
                    }

                    getConfigs(function(configs) {
                        worker_levels=configs.worker_levels;
                        provinces = configs.provinces;

                        //城市
                        var city_id = getUrlQueryString('city_id');
                        if(!city_id) city_id=110100;
                        sort_url= "?city_id="+city_id;
                        if(city_id==120100){
                            $('.city-label').html('天津');
                            $('#city_id_'+city_id).attr("class","selected");
                            $('#city_id_'+110100).attr("class","");
                        }

                        //医院
                        var hospital_id = getUrlQueryString('hospital_id');
                        if(hospital_id){
                            sort_url+= "&hospital_id="+hospital_id;
                        }

                        //科室
                        var department_id = getUrlQueryString('department_id');
                        if(department_id){
                            sort_url+= "&department_id="+department_id;
                        }

                        //开始时间
                        var start_time = getUrlQueryString('start_time');
                        if(start_time) {
                            sort_url+= "&start_time="+start_time;
                        }else{
                            start_time = 0;
                        }

                        var end_time = getUrlQueryString('end_time');
                        if(end_time) {
                            sort_url+= "&end_time="+end_time;
                        }else{
                            end_time=0;
                        }

                        if(start_time && end_time) {
                            var start = new Date(start_time).format("M月d日");
                            var end = new Date(end_time).format("M月d日");
                            $('.nurses-filter-tips').html("服务时间："+start+"-"+end+" 共"+getOrderCycle(start_time,end_time)+"天");
                        }

                        //性别
                        var gender_value = 0;
                        var gender = getUrlQueryString('gender');
                        if(gender){
                            sort_url+= "&gender="+gender;
                        }

                        //籍贯
                        var native_province = getUrlQueryString('native_province');
                        if(native_province){
                            sort_url+= "&native_province="+native_province;
                        }

                        //护工等级
                        var worker_level = getUrlQueryString('worker_level');
                        if(worker_level){
                            sort_url+= "&worker_level="+worker_level;
                        }

                        //排序 price_down price_up star_down star_up start_work_down start_work_up birth_down birth_up score_down score_up
                        var sort = getUrlQueryString('sort');
                        if(!sort) sort = 'star_down';

                        //排序 start
                        var sort_html = ' <ul class="options">';
                        if(sort=='star_down' || !sort){
                            sort_html+='<li><a href="'+sort_url+'&sort=star_down" class="selected">好评最多</a></li> ';
                        }else{
                            sort_html+='<li><a href="'+sort_url+'&sort=star_down">好评最多</a></li> ';
                        }

                        if(sort=='price_down'){
                            sort_html+='<li><a href="'+sort_url+'&sort=price_down" class="selected">等级最高</a></li> ';
                        }else{
                            sort_html+='<li><a href="'+sort_url+'&sort=price_down">等级最高</a></li> ';
                        }

                        if(sort=='price_up'){
                            sort_html+='<li><a href="'+sort_url+'&sort=price_up" class="selected">价格最低</a></li>';
                        }else{
                            sort_html+='<li><a href="'+sort_url+'&sort=price_up">价格最低</a></li>';
                        }

                        if(sort=='birth_down'){
                            sort_html+='<li><a href="'+sort_url+'&sort=birth_down" class="selected">年龄最小</a></li>';
                        }else{
                            sort_html+='<li><a href="'+sort_url+'&sort=birth_down">年龄最小</a></li> ';
                        }
                        sort_html+='</ul>';
                        $('#sort').html(sort_html);
                        //排序 end

                        //性别 start
                        select_num = 0;
                        if(gender){
                            select_num++;
                            var gender_html = '<ul class="options"><li data-value="">全部</li>' ;
                        }else{
                            var gender_html = '<ul class="options"><li data-value="" class="selected">全部</li>' ;
                        }
                        if(gender==1){
                            gender_html+='<li data-value="1" class="selected">男</li><li data-value="2">女</li> ';
                        }else if(gender==2){
                            gender_html+='<li data-value="1">男</li><li data-value="2"  class="selected">女</li> ';
                        }else{
                            gender_html+='<li data-value="1">男</li><li data-value="2">女</li> ';
                        }
                        gender_html+= '</ul>';
                        console.log(gender_html);
                        $('.gender').html(gender_html);
                        //性别 end

                        //籍贯 start
                        if(native_province){
                            select_num++;
                            var native_province_html = '<ul class="options"><li data-value="">全部</li>' ;
                        }else{
                            var native_province_html = '<ul class="options"><li data-value="" class="selected">全部</li>' ;
                        }
                        for(var i=0;i<provinces.length;i++){
                            if(native_province==provinces[i].id){
                                native_province_html+= '<li data-value="'+provinces[i].id+'" class="selected">'+provinces[i].name+'</li> ' ;
                            }else{
                                native_province_html+= '<li data-value="'+provinces[i].id+'">'+provinces[i].name+'</li> ' ;
                            }

                        }
                        native_province_html+= '</ul>';
                        $('.native_province').html(native_province_html);
                        //籍贯 end

                        //护理员级别 start
                        if(worker_level){
                            select_num++;
                            var worker_level_html = '<ul class="options"><li data-value="">全部</li>' ;
                        }else{
                            var worker_level_html = '<ul class="options"><li data-value="" class="selected">全部</li>' ;
                        }

                        for(var i=0;i<worker_levels.length;i++){
                            if(worker_level==worker_levels[i].id){
                                worker_level_html+= '<li data-value="'+worker_levels[i].id+'" class="selected">'+worker_levels[i].name+'</li> ' ;
                            }else{
                                worker_level_html+= '<li data-value="'+worker_levels[i].id+'">'+worker_levels[i].name+'</li> ' ;
                            }

                        }
                        worker_level_html+= '</ul>';
                        $('.worker_level').html(worker_level_html);
                        //护理员级别 end

                        $('#select_num').attr('data-badge',select_num);

                        //设置时间控件默认的开始和结束时间
                        if(!start_time && !end_time){
                            $('#start-time').val(new Date().format("yyyy-MM-dd"));
                            var nd = new Date();
                            nd = nd.valueOf();
                            nd = nd + 10 * 24 * 60 * 60 * 1000;
                            nd = new Date(nd).format("yyyy-MM-dd");
                            $('#end-time').val(nd);
                            var free = 'no';
                        }else{
                            $('#start-time').val(start_time);
                            $('#end-time').val(end_time);
                            var free = 'yes';
                        }

                        if(gender==1)
                            gender_value = "男";
                        else if(gender==2)
                            gender_value = "女";
                        $.ajax({
                            url: workerUrl_v2,
                            data: {
                                page: pageNum,
                                city_id:city_id,
                                hospital_id:hospital_id,
                                department_id:department_id,
                                start_time:start_time,
                                gender:gender_value,
                                native_province:native_province,
                                worker_level:worker_level,
                                sort:sort,
                                count: 100,
                                free:free
                            },
                            type: 'get',
                            success: function (response) {
                                console.log(response);
                                if (response.data.items.length<1) {
                                    window.removeEventListener('scroll', load);
                                    loading.classList.remove('loading');
                                    loading.innerHTML = '\u5df2\u7ecf\u5230\u6700\u540e\u4e86~';
                                    loading = null;
                                } else {
                                    var responseHtml="";
                                    for(var i=0;i<response.data.items.length;i++){
                                        if(response.data.items[i].office_id!=null) {
                                            var office_str=response.data.items[i].office_id;
                                        }else{
                                            var office_str="";
                                        }
                                        responseHtml+='<li>';
                                        responseHtml+='<a href="./nursesDetail.html?worker_id='+response.data.items[i].worker_id+'&start_time='+start_time+'&end_time='+end_time+'&in_service='+response.data.items[i].in_service+'">';
                                        responseHtml+='<div class="nurses-photo" style="background-image: url('+response.data.items[i].pic+')"></div>';
                                        responseHtml+='<div class="nurses-detail">';
                                        responseHtml+='<span class="nurses-price"><em>'+parseInt(response.data.items[i].price)+'</em>元/天</span>';
                                        responseHtml+='<span class="nurses-rate">★★★★★</span>';
                                        responseHtml+='<h4 class="nurses-name">'+response.data.items[i].name+'</h4>';
                                        responseHtml+='<p class="nurses-intro">'+ages(response.data.items[i].birth)+'岁 | '+response.data.items[i].native_province+' | '+ages(response.data.items[i].start_work)+'年护理经验</p>';
                                        responseHtml+='<p class="nurses-reserve">';
                                        //responseHtml+='<span class=" ';
                                        //if(response.data.items[i].level==1) responseHtml+='care-level-junior';
                                        //else if (response.data.items[i].level==2) responseHtml+='care-level-middle';
                                        //else if (response.data.items[i].level==3) responseHtml+='care-level-hight';
                                        //else if (response.data.items[i].level==4) responseHtml+='care-level-special';
                                        if(response.data.items[i].level)
                                            responseHtml+=response.data.items[i].level_name+'</span>';
                                        if(response.data.items[i].in_service)
                                            responseHtml+='<span class="status-busy nurses-status">服务中</span>';
                                        else
                                            responseHtml+='<span class="nurses-status">空闲</span>';
                                        responseHtml+='</p>';
                                        responseHtml+='</div>';
                                        responseHtml+='</a>';
                                        responseHtml+='</li> ';
                                    }
                                    if (list.insertAdjacentHTML) {
                                        list.insertAdjacentHTML('beforeEnd', responseHtml);
                                    } else {
                                        var fra = document.createDocumentFragment(), temp = document.createElement('div');
                                        div.innerHTML = responseHtml;
                                        [].forEach.call(div.children, function (li) {
                                            fra.appendChild(li);
                                        });
                                        list.appendChild(fra);
                                    }
                                    isLoading && window.addEventListener('scroll', load);
                                    isLoading = 0;
                                }
                            },
                            error: function () {
                                isLoading && window.addEventListener('scroll', load);
                                isLoading = 0;
                            }
                        });
                    });
                }
            }
        }
        window.addEventListener('load', load);
    }();
}

/**
 * 护理员详情
 */
function get_workedetail() {
    var worker_id = getUrlQueryString("worker_id");
    var start_time = getUrlQueryString("start_time");
    var end_time = getUrlQueryString("end_time");
    var in_service = getUrlQueryString("in_service");
    var workeDetailUrl=workerUrl+"/"+worker_id;
    $.getJSON(workeDetailUrl, function (response) {
        if (response.code == 200) {console.log(response.data);
            template.helper('dateFormat', function (str) {
                return ages(str);
            });
            response.data.start_time = start_time;
            response.data.end_time = end_time;
            response.data.in_service = in_service;
            var bodyHtml = template('bodyTemplate', response);
            $('#nurses_detail').html(bodyHtml);
            $('#price').html(parseInt(response.data.price));
        }
    });
}

/**
 *
 * @param worker_id
 * @param start_time
 * @param end_time
 */
function pay(worker_id,start_time,end_time){
    if(start_time!=0 && end_time!=0){
        location.href="/reserve.html?worker_id="+worker_id+"&start_time="+start_time+"&end_time="+end_time;
    }else{
        alert("请先设置服务开始时间和服务结束时间！");
        location.href="/";
    }
}