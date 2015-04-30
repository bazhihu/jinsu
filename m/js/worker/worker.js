$.getJSON(workerUrl,function(response){
    if(response.code == 200){
        var bodyHtml = template('bodyTemplate', response);
        $('#body').html(bodyHtml);
    }
})