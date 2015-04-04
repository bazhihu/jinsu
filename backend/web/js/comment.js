//评论审核
$(function(){
    $("#audit_yes").click(function(){
        if(!confirm('确认执行此操作吗？')){
            return false;
        }else{
            $("#comment").submit();
        }
    });
});