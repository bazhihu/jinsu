//评价审核
$(function(){
    $("#audit_yes").click(function(){
        if(!confirm('确认执行此操作吗？')){
            return false;
        }else{
            $("#op").val('audit_yes');
            $("#comment").submit();
        }
    });
    $("#audit_no").click(function(){
        if(!confirm('确认执行此操作吗？')){
            return false;
        }else{
            $("#op").val('audit_no');
            $("#comment").submit();
        }
    });
});