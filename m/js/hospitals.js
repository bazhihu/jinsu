var url = configUrl;
getDataJson(url, function(err,backData){
    if(!err){
        getConfigs(function(configs) {
            var hospitals_html = template('hospitals_template', configs);
            $('#hospitals').html(hospitals_html);
        });
    }
});


    $("#dianji").on("click", function () {
        alert("点击了父节点")
    });