loggedIn();
var user = getStatus();
    patientUrl = patientUrl_v2+'?user_id='+user.id;
$.getJSON(patientUrl, function(backData){console.log(backData);
    if(backData.data.length){
        for(var i=0;i<backData.data.length;i++){
            backData.data[i].val = '{"name":"'+backData.data[i].name+'","gender":"'+backData.data[i].gender+'","age":"'+backData.data[i].age+'","height":"'+backData.data[i].height+'","weight":"'+backData.data[i].weight+'"}';
        }
        var patient = backData.data,
            data = {
                title: '被护理人',
                list: patient
            },
            html = template('patient', data);
        document.getElementById('content').innerHTML = html;
    }else{
        $(".add-button").attr('style','display:none');
    }
});
$('.save').on('click', function () {
    var name = $('#name').val(),
        gender = $('#gender').val(),
        age = $('#age').val(),
        height = $('#height').val(),
        weight = $('#weight').val(),
        regName = /^([\u4e00-\u9fa5]){2,7}$/,
        reg = /^\d+$/,
        data = '{"name":"'+name+'","gender":"'+gender+'","age":"'+age+'","height":"'+height+'","weight":"'+weight+'"}';

        if(!name || !regName.test(name)){
            alert('请输入正确的名字！');
            return false;
        }
        if(!gender || !reg.test(gender)){
            alert('请输入正确的性别！');
            return false;
        }
        if(!age || !reg.test(age) || age<1 || age>150){//1-150
            alert('请输入正确的年龄！');
            return false;
        }
        if(!height || !reg.test(height) || height<10 || height>300){//10-300
            alert('请输入正确的身高！');
            return false;
        }
        if(!weight || !reg.test(weight) || weight<1 || weight>500){//1-500
            alert('请输入正确的体重！');
            return false;
        }
    try {
        window.parent.$.dismissPopup({ value: data, text: name });
    } catch (error) {
        window.history.back(1);
    }
});

/*; ~function () {
var patient =  $("#patient").val();
}();*/

/*
$('#header .back').click(function (e) {
    var selected = document.querySelector('.departments .selected');
    try {
        window.parent.$.dismissPopup(selected ? { value: selected.getAttribute('data-value'), text: selected.innerText || selected.textContent } : null);
    } catch (error) {
        window.history.back(1);
    }
});*/
