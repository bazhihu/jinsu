; $(function () {
    loggedIn();
    var start = getUrlQueryString('start_time'),
        end = getUrlQueryString('end_time'),
        hospital_id = getUrlQueryString('hospital_id'),
        workerNo = getUrlQueryString('worker_id'),
        hasRead = 1;
    if(!workerNo){
        location.href = "/";
    }
    $('#workerId').val(workerNo);
    if((start && end) && (start!=0 || end!=0)){
        //服务时间
        var cycle = getOrderCycle(start,end),
            startData = start.substr(5,2)+'月'+start.substr(8,2)+'日',
            endData = end.substr(5,2)+'月'+end.substr(8,2)+'日';
        $('.shitTime').html(startData+'-'+endData+' <em class="nurses-days">共'+cycle+'天</em>');
        $('#start').val(start);
        $('#end').val(end);
    }else{
        $('.hasHours').attr('style','display:none');
    }
    if(hospital_id){
        var hospitalName = '';
        getConfigs(function(back){
            var hospital = back.hospitals,
                hosLen = hospital.length;
            for(var i=0;i<hosLen;i++){
                if(hospital[i].id ==hospital_id){
                    hospitalName = hospital[i].name;
                }
            }
            $('.hospitalsVal').html(hospitalName);
            $('#service-site').val(hospital_id);
        });
    }

    $('#agreement').on(CLICK,function(){

        if(hasRead ==1){
            hasRead = 0;
            $('#submit').attr('style','background: #ccc;border-top: #ccc;');
        }else{
            hasRead = 1;
            $('#submit').attr('style','background: #34cba8;border-top: 1px solid #3be1bb;');
        }
    });

    //护工信息
    getWorker(function(back){
        var pic = $('.nurses-photo'),
            levelName = $('.care-level'),
            name = $('.nurses-name'),
            workerId = $('.code');

        pic.attr('style','background-image: url('+back.pic+')');
        levelName.html(back.level_name);
        levelName.attr();//图标 todo huzq
        name.html(back.name);
        workerId.html("工号："+back.worker_id);
    });

    $("#submit").on(CLICK, function(e){
        if(hasRead ==0){
            return false;
        }

        var workerId = $('#workerId').val(),
            startData = $('#start').val(),
            endData = $('#end').val(),
            patient = $('#patient').val(),
            serviceSite = $('#service-site').val(),
            disease = $('#disease').val(),
            misc = $('#misc').val();
        //护工编号
        if(!workerId){
            location.href = '/';
            return false;
        }
        //开始时间和结束时间
        if(!startData || !endData){
            alert('请选择开始结束时间');
            return false;
        }
        //被护理人
        if(!patient){
            alert('请输入被护理人信息');
            return false;
        }
        //医院
        if(!serviceSite){
            alert('请选择医院');
            return false;
        }
        var data = {"workerId":workerId,"startData":startData,"endData":endData,"patient":patient,"serviceSite":serviceSite,"disease":disease,"misc":misc};
        var toData = JSON.stringify(data);
        //保存订单信息
        setLocal(orderDate,toData);
        location.href = '/orderConfirm.html?type=select';
    });

    getConfigs(function(back){
        var areas = back.areas,
            hospitals = back.hospitals,
            departments = back.departments,
            areasLen = areas.length,
            hospitalsLen = hospitals.length,
            departmentsLen = departments.length,

            hos = $('#hospitals'),
            dep = $('#department');

        var hospitalList  = new Object();

        var bro = new Object();
        for(var K = 0;K<hospitalsLen;K++){

            var koo = hospitals[K],
                ooo = new Object();
            ooo.id = koo.id;
            ooo.name = koo.name;
            bro[K] = ooo;
        }
        hospitalList[0] = bro;
        //医院
        for(var i = 0;i<areasLen;i++){
            var li  = areas[i],
                options = new Object(),
                index = 1;

            for(var j = 0;j<hospitalsLen;j++){
                var ai = hospitals[j],
                    il = new Object();
                if(li.id == ai.area_id){
                    il.id = ai.id;
                    il.name = ai.name;
                    index ++;
                    options[index] = il;
                }
            }
            hospitalList[li.id] = options;
        }
        //区
        var zone = new Object();
        zone[0] = {id:0,name:'全部'};
        for(var m = 0;m<areasLen;m++){
            zone[m+1] = {id:areas[m].id,name:areas[m].name};
        }

        //科室
        var father = new Object(),
            child = new Object(),
            index = 0;
        for(var i = 0;i<departmentsLen;i++){
              var sub = departments[i];
            if(sub.parent_id == 0){
                var lh = new Object(),
                    lp = new Object(),
                    lo = 0;
                lh.id = sub.id;
                lh.name = sub.name;
                father[i] = lh;

                for(var j = 0;j<departmentsLen;j++){
                    var sit = departments[j],
                        hp = child[index],
                        go = new Object();
                    if(sit.parent_id == sub.id){
                        go.id = sit.id;
                        go.name = sit.name;
                        lp[lo] = go;
                        lo ++;
                    }
                }
                child[sub.id] = lp;
            }
            index ++;
        }

        var msgHospitals = {
            areas: zone,
            hospitalList: hospitalList
        };

        var htmlHospitals = template('contentHospital', msgHospitals);
        document.getElementById('hospitals').innerHTML = htmlHospitals;

        var msgDepartment = {
            father: father,
            child: child
        };
        var htmlDepartment = template('contentDepartment', msgDepartment);
        document.getElementById('department').innerHTML = htmlDepartment;
    });

    /**
     * 护理员详情
     */
    function getWorker(callback) {
        var workerNo = getUrlQueryString('worker_id'),
            workersUrl = workerUrl_v2+'/'+workerNo;
        $.getJSON(workersUrl, function (response) {
            if (response.code == 200) {
                callback(response.data);
            }
        });
    }
});