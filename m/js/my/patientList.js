loggedIn();
var user = getStatus();
patientUrl = patientUrl_v2+'?user_id='+user.id;
$.getJSON(patientUrl, function(backData){
    if(backData.data.length){
        $(".add-button").attr('style','display:none');
        var patient = backData.data;
        for(var i=0;i<patient.length;i++){
            patient[i].nameUrl =escape(patient[i].name).toLocaleLowerCase().replace(/%u/gi, '\\u');
        }
        var data = {
                title: '被护理人',
                list: patient
            },
            html = template('patient', data);console.log(patient);
        document.getElementById('content').innerHTML = html;
    }
});