//评价审核
$(function(){
    $("#audit_yes").click(function(){
        if(!confirm('确认执行此操作吗？')){
            return false;
        }else{
            $("#op").val('audit_yes');
            $("#comment").submit();
            alert('操作已成功！');
        }
    });

    $("#audit_no").click(function(){
        if(!confirm('确认执行此操作吗？')){
            return false;
        }else{
            $("#op").val('audit_no');
            if($("#comment").submit())
                alert('操作已成功！');
        }
    });
});